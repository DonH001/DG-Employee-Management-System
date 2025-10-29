<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Departments
        $departments = [
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'Handles all technology needs and development'],
            ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Manages employee relations and recruitment'],
            ['name' => 'Accounting', 'code' => 'ACC', 'description' => 'Financial management and bookkeeping'],
            ['name' => 'Sales', 'code' => 'SALES', 'description' => 'Customer acquisition and relationship management'],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Day-to-day operations and service delivery'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create Positions
        $positions = [
            // IT Positions
            ['title' => 'Software Developer', 'department_id' => 1, 'level' => 'mid', 'min_salary' => 60000, 'max_salary' => 90000],
            ['title' => 'Senior Developer', 'department_id' => 1, 'level' => 'senior', 'min_salary' => 80000, 'max_salary' => 120000],
            ['title' => 'IT Manager', 'department_id' => 1, 'level' => 'manager', 'min_salary' => 100000, 'max_salary' => 150000],
            ['title' => 'System Administrator', 'department_id' => 1, 'level' => 'mid', 'min_salary' => 55000, 'max_salary' => 85000],
            
            // HR Positions
            ['title' => 'HR Specialist', 'department_id' => 2, 'level' => 'mid', 'min_salary' => 45000, 'max_salary' => 65000],
            ['title' => 'HR Manager', 'department_id' => 2, 'level' => 'manager', 'min_salary' => 70000, 'max_salary' => 100000],
            
            // Accounting Positions
            ['title' => 'Accountant', 'department_id' => 3, 'level' => 'mid', 'min_salary' => 40000, 'max_salary' => 60000],
            ['title' => 'Senior Accountant', 'department_id' => 3, 'level' => 'senior', 'min_salary' => 55000, 'max_salary' => 80000],
            
            // Sales Positions
            ['title' => 'Sales Representative', 'department_id' => 4, 'level' => 'entry', 'min_salary' => 35000, 'max_salary' => 50000],
            ['title' => 'Sales Manager', 'department_id' => 4, 'level' => 'manager', 'min_salary' => 60000, 'max_salary' => 90000],
            
            // Operations Positions
            ['title' => 'Operations Coordinator', 'department_id' => 5, 'level' => 'mid', 'min_salary' => 40000, 'max_salary' => 60000],
            ['title' => 'Operations Manager', 'department_id' => 5, 'level' => 'manager', 'min_salary' => 65000, 'max_salary' => 95000],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }

        // Create Admin User
        $adminUser = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@company.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Employee::create([
            'user_id' => $adminUser->id,
            'employee_id' => 'EMP0001',
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'department_id' => 1,
            'position_id' => 3, // IT Manager
            'hire_date' => now()->subYears(2),
            'salary' => 125000,
            'employment_status' => 'active',
            'employment_type' => 'full_time',
        ]);

        // Create HR User
        $hrUser = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'hr@company.com',
            'password' => Hash::make('password123'),
            'role' => 'hr',
            'email_verified_at' => now(),
        ]);

        Employee::create([
            'user_id' => $hrUser->id,
            'employee_id' => 'EMP0002',
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'department_id' => 2,
            'position_id' => 6, // HR Manager
            'hire_date' => now()->subYears(1),
            'salary' => 85000,
            'employment_status' => 'active',
            'employment_type' => 'full_time',
        ]);

        // Create Employee User
        $employeeUser = User::create([
            'name' => 'John Smith',
            'email' => 'employee@company.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);

        Employee::create([
            'user_id' => $employeeUser->id,
            'employee_id' => 'EMP0003',
            'first_name' => 'John',
            'last_name' => 'Smith',
            'department_id' => 1,
            'position_id' => 1, // Software Developer
            'manager_id' => 1, // Reports to System Administrator
            'hire_date' => now()->subMonths(6),
            'salary' => 75000,
            'employment_status' => 'active',
            'employment_type' => 'full_time',
        ]);

        // Create more sample employees
        $sampleEmployees = [
            [
                'name' => 'Jane Doe',
                'email' => 'jane.doe@company.com',
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'employee_id' => 'EMP0004',
                'department_id' => 1,
                'position_id' => 2, // Senior Developer
                'salary' => 95000,
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@company.com',
                'first_name' => 'Mike',
                'last_name' => 'Wilson',
                'employee_id' => 'EMP0005',
                'department_id' => 4,
                'position_id' => 9, // Sales Representative
                'salary' => 42000,
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa.brown@company.com',
                'first_name' => 'Lisa',
                'last_name' => 'Brown',
                'employee_id' => 'EMP0006',
                'department_id' => 3,
                'position_id' => 7, // Accountant
                'salary' => 50000,
            ],
        ];

        foreach ($sampleEmployees as $emp) {
            $user = User::create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'email_verified_at' => now(),
            ]);

            Employee::create([
                'user_id' => $user->id,
                'employee_id' => $emp['employee_id'],
                'first_name' => $emp['first_name'],
                'last_name' => $emp['last_name'],
                'department_id' => $emp['department_id'],
                'position_id' => $emp['position_id'],
                'manager_id' => 1, // All report to admin for now
                'hire_date' => now()->subMonths(rand(1, 12)),
                'salary' => $emp['salary'],
                'employment_status' => 'active',
                'employment_type' => 'full_time',
            ]);
        }
    }
}