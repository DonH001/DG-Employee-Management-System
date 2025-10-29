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
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('project_manager_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::table('time_entries', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('employees')->onDelete('set null');
        });

        Schema::table('employee_documents', function (Blueprint $table) {
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['project_manager_id']);
        });

        Schema::table('time_entries', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
        });

        Schema::table('employee_documents', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
        });
    }
};