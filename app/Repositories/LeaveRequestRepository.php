<?php

namespace App\Repositories;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeaveRequestRepository
{
    protected $cacheTime = 3600; // 1 hour

    /**
     * Get paginated leave requests with filters
     */
    public function getPaginatedLeaveRequests($request, $perPage = 15): LengthAwarePaginator
    {
        $query = LeaveRequest::with(['employee.user']);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Employee filter
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Leave type filter
        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        return $query->latest('created_at')->paginate($perPage)->withQueryString();
    }

    /**
     * Get leave requests for a specific employee
     */
    public function getEmployeeLeaveRequests($employeeId, $status = null): Collection
    {
        $cacheKey = "leave_requests.employee.{$employeeId}." . ($status ?? 'all');
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($employeeId, $status) {
            $query = LeaveRequest::where('employee_id', $employeeId);
            
            if ($status) {
                $query->where('status', $status);
            }
            
            return $query->orderBy('created_at', 'desc')->get();
        });
    }

    /**
     * Get paginated leave requests for a specific employee
     */
    public function getPaginatedEmployeeLeaveRequests($employeeId, $perPage = 10): LengthAwarePaginator
    {
        return LeaveRequest::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get pending leave requests
     */
    public function getPendingLeaveRequests(): Collection
    {
        return Cache::remember('leave_requests.pending', 1800, function () {
            return LeaveRequest::with(['employee.user'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->get();
        });
    }

    /**
     * Get leave statistics for dashboard
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard.leave_stats', $this->cacheTime, function () {
            $thisMonth = Carbon::now()->startOfMonth();
            $thisYear = Carbon::now()->startOfYear();
            
            return [
                'pending_requests' => LeaveRequest::where('status', 'pending')->count(),
                'approved_this_month' => LeaveRequest::where('status', 'approved')
                    ->where('created_at', '>=', $thisMonth)
                    ->count(),
                'rejected_this_month' => LeaveRequest::where('status', 'rejected')
                    ->where('created_at', '>=', $thisMonth)
                    ->count(),
                'total_this_year' => LeaveRequest::where('created_at', '>=', $thisYear)->count(),
                'leave_types_breakdown' => LeaveRequest::select('leave_type', DB::raw('count(*) as count'))
                    ->where('created_at', '>=', $thisYear)
                    ->groupBy('leave_type')
                    ->pluck('count', 'leave_type')
                    ->toArray(),
            ];
        });
    }

    /**
     * Get leave balance for an employee
     */
    public function getLeaveBalance($employeeId): array
    {
        return Cache::remember("leave_balance.{$employeeId}", $this->cacheTime, function () use ($employeeId) {
            $currentYear = Carbon::now()->year;
            $startOfYear = Carbon::createFromDate($currentYear, 1, 1);
            
            $approvedLeaves = LeaveRequest::where('employee_id', $employeeId)
                ->where('status', 'approved')
                ->where('start_date', '>=', $startOfYear)
                ->get();

            // Calculate days used per leave type
            $leaveTypesUsed = [];
            foreach ($approvedLeaves as $leave) {
                $type = $leave->leave_type;
                $days = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
                
                if (!isset($leaveTypesUsed[$type])) {
                    $leaveTypesUsed[$type] = 0;
                }
                $leaveTypesUsed[$type] += $days;
            }

            // Standard leave allocations (can be made configurable)
            $allocations = [
                'vacation' => 15,
                'sick' => 10,
                'personal' => 5,
                'emergency' => 3,
            ];

            $balances = [];
            foreach ($allocations as $type => $allocated) {
                $used = $leaveTypesUsed[$type] ?? 0;
                $balances[$type] = [
                    'allocated' => $allocated,
                    'used' => $used,
                    'remaining' => $allocated - $used,
                ];
            }

            return $balances;
        });
    }

    /**
     * Get leave requests expiring soon (for reminders)
     */
    public function getExpiringSoon($days = 30): Collection
    {
        $futureDate = Carbon::now()->addDays($days);
        
        return LeaveRequest::with(['employee.user'])
            ->where('status', 'approved')
            ->where('start_date', '<=', $futureDate)
            ->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->get();
    }

    /**
     * Clear leave request cache
     */
    public function clearCache($employeeId = null): void
    {
        Cache::forget('dashboard.leave_stats');
        Cache::forget('leave_requests.pending');
        
        if ($employeeId) {
            Cache::forget("leave_requests.employee.{$employeeId}.all");
            Cache::forget("leave_requests.employee.{$employeeId}.pending");
            Cache::forget("leave_requests.employee.{$employeeId}.approved");
            Cache::forget("leave_requests.employee.{$employeeId}.rejected");
            Cache::forget("leave_balance.{$employeeId}");
        }
    }
}