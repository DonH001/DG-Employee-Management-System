<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    protected $cacheTime = 1800; // 30 minutes (shorter cache for attendance data)

    /**
     * Get today's attendance for an employee
     */
    public function getTodayAttendance($employeeId): ?Attendance
    {
        $today = Carbon::today()->format('Y-m-d');
        
        return Cache::remember("attendance.today.{$employeeId}", 300, function () use ($employeeId, $today) {
            return Attendance::where('employee_id', $employeeId)
                ->where('date', $today)
                ->first();
        });
    }

    /**
     * Get recent attendance records for an employee
     */
    public function getRecentAttendance($employeeId, $days = 7): Collection
    {
        $startDate = Carbon::now()->subDays($days)->format('Y-m-d');
        
        return Attendance::where('employee_id', $employeeId)
            ->where('date', '>=', $startDate)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get paginated attendance records for an employee
     */
    public function getPaginatedEmployeeAttendance($employeeId, $perPage = 15): LengthAwarePaginator
    {
        return Attendance::where('employee_id', $employeeId)
            ->orderBy('date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get paginated attendance records with filters and optimized eager loading
     */
    public function getPaginatedAttendance($request, $perPage = 20): LengthAwarePaginator
    {
        $query = Attendance::with([
            'employee:id,first_name,last_name,employee_id,user_id',
            'employee.user:id,name,email'
        ])->select('id', 'employee_id', 'date', 'time_in', 'time_out', 'status', 'total_hours', 'break_duration');

        // Date range filter
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // Employee filter
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest('date')->paginate($perPage)->withQueryString();
    }

    /**
     * Get attendance statistics for dashboard
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard.attendance_stats', $this->cacheTime, function () {
            $today = Carbon::today()->format('Y-m-d');
            $thisMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            
            return [
                'present_today' => Attendance::where('date', $today)
                    ->whereIn('status', ['present', 'late'])
                    ->count(),
                'late_today' => Attendance::where('date', $today)
                    ->where('status', 'late')
                    ->count(),
                'absent_today' => Attendance::where('date', $today)
                    ->where('status', 'absent')
                    ->count(),
                'total_hours_this_month' => Attendance::where('date', '>=', $thisMonth)
                    ->sum('total_hours'),
                'average_hours_per_day' => Attendance::where('date', '>=', $thisMonth)
                    ->whereNotNull('total_hours')
                    ->avg('total_hours'),
            ];
        });
    }

    /**
     * Get monthly attendance report data
     */
    public function getMonthlyReport($month = null, $year = null): array
    {
        $month = $month ?: Carbon::now()->month;
        $year = $year ?: Carbon::now()->year;
        
        $cacheKey = "attendance.monthly_report.{$year}.{$month}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($month, $year) {
            return DB::select("
                SELECT 
                    e.id as employee_id,
                    CONCAT(e.first_name, ' ', e.last_name) as employee_name,
                    COUNT(a.id) as total_days,
                    SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as present_days,
                    SUM(CASE WHEN a.status = 'late' THEN 1 ELSE 0 END) as late_days,
                    SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) as absent_days,
                    COALESCE(SUM(a.total_hours), 0) as total_hours
                FROM employees e
                LEFT JOIN attendances a ON e.id = a.employee_id 
                    AND MONTH(a.date) = ? 
                    AND YEAR(a.date) = ?
                WHERE e.employment_status = 'active'
                GROUP BY e.id, e.first_name, e.last_name
                ORDER BY e.first_name, e.last_name
            ", [$month, $year]);
        });
    }

    /**
     * Clear attendance cache
     */
    public function clearCache($employeeId = null): void
    {
        Cache::forget('dashboard.attendance_stats');
        
        if ($employeeId) {
            Cache::forget("attendance.today.{$employeeId}");
        }
        
        // Clear monthly report cache for current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        Cache::forget("attendance.monthly_report.{$currentYear}.{$currentMonth}");
    }
}