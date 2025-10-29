<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to employees table (only if they don't exist)
        Schema::table('employees', function (Blueprint $table) {
            // Skip indexes that might already exist from foreign key constraints
            $table->index('employment_status');
            $table->index('employment_type');
            $table->index('hire_date');
            $table->index(['first_name', 'last_name']);
        });

        // Add indexes to attendance table
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('date');
            $table->index('status');
            $table->index(['employee_id', 'date']); // Composite index for common queries
            $table->index(['date', 'status']); // For date-based status filtering
        });

        // Add indexes to leave_requests table
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['employee_id', 'status']); // Composite index
            $table->index(['start_date', 'end_date']); // Date range queries
        });

        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('email_verified_at');
        });

        // Add indexes to departments table
        Schema::table('departments', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Add indexes to positions table
        Schema::table('positions', function (Blueprint $table) {
            $table->index('department_id');
            $table->index('is_active');
            $table->index('level');
            $table->index(['department_id', 'is_active']); // Composite index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from employees table
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['employment_status']);
            $table->dropIndex(['employment_type']);
            $table->dropIndex(['hire_date']);
            $table->dropIndex(['first_name', 'last_name']);
        });

        // Remove indexes from attendance table
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['employee_id', 'date']);
            $table->dropIndex(['date', 'status']);
        });

        // Remove indexes from leave_requests table
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['start_date']);
            $table->dropIndex(['end_date']);
            $table->dropIndex(['employee_id', 'status']);
            $table->dropIndex(['start_date', 'end_date']);
        });

        // Remove indexes from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email_verified_at']);
        });

        // Remove indexes from departments table
        Schema::table('departments', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Remove indexes from positions table
        Schema::table('positions', function (Blueprint $table) {
            $table->dropIndex(['department_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['level']);
            $table->dropIndex(['department_id', 'is_active']);
        });
    }
};
