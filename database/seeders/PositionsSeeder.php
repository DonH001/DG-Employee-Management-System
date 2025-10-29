<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments to assign positions to
        $departments = Department::all();
        
        if ($departments->isEmpty()) {
            // Create basic departments first if they don't exist
            $deptData = [
                ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'Handles all technology needs and development'],
                ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Manages employee relations and recruitment'],
                ['name' => 'Accounting', 'code' => 'ACC', 'description' => 'Handles financial operations and reporting'],
                ['name' => 'Sales', 'code' => 'SAL', 'description' => 'Manages sales operations and customer relations'],
                ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Oversees daily operations and logistics'],
            ];
            
            foreach ($deptData as $dept) {
                Department::firstOrCreate(['code' => $dept['code']], $dept);
            }
            
            $departments = Department::all();
        }
        
        $itDept = $departments->where('code', 'IT')->first();
        $hrDept = $departments->where('code', 'HR')->first();
        $accDept = $departments->where('code', 'ACC')->first();
        $salDept = $departments->where('code', 'SAL')->first();
        $opsDept = $departments->where('code', 'OPS')->first();

        $positions = [
            // IT Positions
            ['title' => 'Software Developer', 'department_id' => $itDept->id ?? 1, 'level' => 'mid', 'min_salary' => 60000, 'max_salary' => 90000, 'is_active' => true],
            ['title' => 'Senior Developer', 'department_id' => $itDept->id ?? 1, 'level' => 'senior', 'min_salary' => 80000, 'max_salary' => 120000, 'is_active' => true],
            ['title' => 'IT Manager', 'department_id' => $itDept->id ?? 1, 'level' => 'manager', 'min_salary' => 100000, 'max_salary' => 150000, 'is_active' => true],
            ['title' => 'System Administrator', 'department_id' => $itDept->id ?? 1, 'level' => 'mid', 'min_salary' => 55000, 'max_salary' => 85000, 'is_active' => true],
            
            // HR Positions
            ['title' => 'HR Specialist', 'department_id' => $hrDept->id ?? 2, 'level' => 'mid', 'min_salary' => 45000, 'max_salary' => 65000, 'is_active' => true],
            ['title' => 'HR Manager', 'department_id' => $hrDept->id ?? 2, 'level' => 'manager', 'min_salary' => 70000, 'max_salary' => 100000, 'is_active' => true],
            
            // Accounting Positions
            ['title' => 'Accountant', 'department_id' => $accDept->id ?? 3, 'level' => 'mid', 'min_salary' => 40000, 'max_salary' => 60000, 'is_active' => true],
            ['title' => 'Senior Accountant', 'department_id' => $accDept->id ?? 3, 'level' => 'senior', 'min_salary' => 55000, 'max_salary' => 80000, 'is_active' => true],
            
            // Sales Positions
            ['title' => 'Sales Representative', 'department_id' => $salDept->id ?? 4, 'level' => 'entry', 'min_salary' => 35000, 'max_salary' => 50000, 'is_active' => true],
            ['title' => 'Sales Manager', 'department_id' => $salDept->id ?? 4, 'level' => 'manager', 'min_salary' => 60000, 'max_salary' => 90000, 'is_active' => true],
            
            // Operations Positions
            ['title' => 'Operations Coordinator', 'department_id' => $opsDept->id ?? 5, 'level' => 'mid', 'min_salary' => 40000, 'max_salary' => 60000, 'is_active' => true],
            ['title' => 'Operations Manager', 'department_id' => $opsDept->id ?? 5, 'level' => 'manager', 'min_salary' => 65000, 'max_salary' => 95000, 'is_active' => true],
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate(
                ['title' => $position['title'], 'department_id' => $position['department_id']],
                $position
            );
        }
        
        $this->command->info('Positions seeded successfully!');
    }
}