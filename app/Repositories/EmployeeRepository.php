<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class EmployeeRepository
{
    protected $cacheTime = 3600; // 1 hour

    /**
     * Get active employees with caching and optimized eager loading
     */
    public function getActiveEmployees(): Collection
    {
        return Cache::remember('employees.active', $this->cacheTime, function () {
            return Employee::with([
                    'department:id,name', 
                    'position:id,title', 
                    'user:id,name,email'
                ])
                ->select('id', 'user_id', 'employee_id', 'first_name', 'last_name', 'department_id', 'position_id', 'employment_status')
                ->where('employment_status', 'active')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
        });
    }

    /**
     * Get paginated employees with filters and optimized queries
     */
    public function getPaginatedEmployees($request, $perPage = 15): LengthAwarePaginator
    {
        $query = Employee::with([
            'department:id,name,code', 
            'position:id,title', 
            'user:id,name,email'
        ])->select('id', 'user_id', 'employee_id', 'first_name', 'last_name', 'department_id', 'position_id', 'employment_status', 'employment_type', 'hire_date');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        return $query->orderBy('first_name')->orderBy('last_name')->paginate($perPage)->withQueryString();
    }

    /**
     * Get employee by ID with all relationships
     */
    public function getEmployeeById($id): ?Employee
    {
        return Cache::remember("employee.{$id}", $this->cacheTime, function () use ($id) {
            return Employee::with([
                'department:id,name,description', 
                'position:id,title,description', 
                'user:id,name,email,created_at',
                'attendances' => function ($query) {
                    $query->latest()->take(10);
                },
                'leaveRequests' => function ($query) {
                    $query->latest()->take(5);
                }
            ])->find($id);
        });
    }

    /**
     * Get dashboard statistics with caching
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard.employee_stats', $this->cacheTime, function () {
            $thisMonth = Carbon::now()->startOfMonth();
            $thisYear = Carbon::now()->startOfYear();

            return [
                'total_employees' => Employee::count(),
                'active_employees' => Employee::where('employment_status', 'active')->count(),
                'inactive_employees' => Employee::where('employment_status', 'inactive')->count(),
                'new_hires_this_month' => Employee::where('hire_date', '>=', $thisMonth)->count(),
                'new_hires_this_year' => Employee::where('hire_date', '>=', $thisYear)->count(),
                'employment_types' => Employee::selectRaw('employment_type, count(*) as count')
                    ->groupBy('employment_type')
                    ->pluck('count', 'employment_type')
                    ->toArray(),
            ];
        });
    }

    /**
     * Clear employee cache
     */
    public function clearCache($employeeId = null): void
    {
        Cache::forget('employees.active');
        Cache::forget('dashboard.employee_stats');
        
        if ($employeeId) {
            Cache::forget("employee.{$employeeId}");
        }
    }
}