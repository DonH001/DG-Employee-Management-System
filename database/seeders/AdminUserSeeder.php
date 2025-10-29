<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Get or create default department and position
        $department = Department::firstOrCreate(
            ['name' => 'Administration'],
            [
                'description' => 'System Administration Department',
                'code' => 'ADMIN',
                'is_active' => true
            ]
        );

        $position = Position::firstOrCreate(
            ['title' => 'System Administrator'],
            [
                'description' => 'System Administrator Position',
                'is_active' => true
            ]
        );

        // Create employee profile for admin user if not exists
        Employee::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'employee_id' => 'EMP0001',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'department_id' => $department->id,
                'position_id' => $position->id,
                'hire_date' => now(),
                'employment_type' => 'full_time',
                'employment_status' => 'active',
                'salary' => 100000,
            ]
        );

        $this->command->info('Admin user and employee profile created successfully!');
        $this->command->info('Email: admin@company.com');
        $this->command->info('Password: password123');
    }
}
