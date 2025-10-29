<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'hr') {
            return redirect()->route('hr.dashboard');
        } else {
            return redirect()->route('employee.dashboard');
        }
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Email Verification Routes (placeholder)
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->name('verification.send');
});

// Admin Routes
Route::middleware(['auth', App\Http\Middleware\CheckMultipleRoles::class.':admin,hr'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // Employee Management
        Route::resource('employees', EmployeeController::class);
        Route::get('employees/{employee}/documents', [EmployeeController::class, 'documents'])->name('employees.documents');
        
        // Attendance Management
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('attendance/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
        Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        
        // Leave Request Management
        Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::post('leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
        Route::post('leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    });
});

// HR Routes
Route::middleware(['auth', App\Http\Middleware\RoleMiddleware::class.':hr'])->group(function () {
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'hr'])->name('dashboard');
    });
});

// Employee Routes
Route::middleware(['auth', App\Http\Middleware\RoleMiddleware::class.':employee'])->group(function () {
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'employee'])->name('dashboard');
        
        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'employeeIndex'])->name('attendance.index');
        Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
        Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
        Route::get('/attendance/today', [AttendanceController::class, 'todayAttendance'])->name('attendance.today');
        
        // Leave Requests
        Route::get('/leave-requests', [LeaveRequestController::class, 'employeeIndex'])->name('leave-requests.index');
        Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
        Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
    });
});

// Shared Routes (All authenticated users)
Route::middleware('auth')->group(function () {
    // No additional API routes needed for simplified system
});