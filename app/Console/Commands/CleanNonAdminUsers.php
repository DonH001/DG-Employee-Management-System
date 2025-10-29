<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;

class CleanNonAdminUsers extends Command
{
    protected $signature = 'users:clean-non-admin {--force : Force deletion without confirmation}';
    protected $description = 'Remove all employees and HR users, keeping only administrators';

    public function handle()
    {
        $this->info('Starting cleanup of non-admin users...');

        // Get all non-admin users
        $nonAdminUsers = User::where('role', '!=', 'admin')->get();
        
        $this->info("Found {$nonAdminUsers->count()} non-admin users to remove:");
        
        foreach ($nonAdminUsers as $user) {
            $this->line("- {$user->name} ({$user->email}) - Role: {$user->role}");
        }
        
        if ($nonAdminUsers->isEmpty()) {
            $this->info('No non-admin users found.');
            return;
        }
        
        // Ask for confirmation unless --force is used
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete these users and all their related data?')) {
                $this->info('Operation cancelled.');
                return;
            }
        }
        
        $deletedCount = 0;
        
        foreach ($nonAdminUsers as $user) {
            try {
                // Delete related employee data if exists
                if ($user->employee) {
                    $employeeId = $user->employee->id;
                    
                    // Delete attendance records
                    $attendanceCount = Attendance::where('employee_id', $employeeId)->count();
                    Attendance::where('employee_id', $employeeId)->delete();
                    $this->line("  - Deleted {$attendanceCount} attendance records");
                    
                    // Delete leave requests
                    $leaveCount = LeaveRequest::where('employee_id', $employeeId)->count();
                    LeaveRequest::where('employee_id', $employeeId)->delete();
                    $this->line("  - Deleted {$leaveCount} leave requests");
                    
                    // Delete employee record
                    $user->employee->delete();
                    $this->line("  - Deleted employee record");
                }
                
                // Delete user account
                $userName = $user->name;
                $user->delete();
                $this->info("✓ Deleted user: {$userName}");
                $deletedCount++;
                
            } catch (\Exception $e) {
                $this->error("✗ Failed to delete user {$user->name}: " . $e->getMessage());
            }
        }
        
        $this->info("Cleanup completed! Deleted {$deletedCount} users and all their related data.");
        
        // Show remaining admin users
        $adminUsers = User::where('role', 'admin')->get();
        $this->info("Remaining administrator accounts:");
        foreach ($adminUsers as $admin) {
            $this->line("- {$admin->name} ({$admin->email})");
        }
    }
}