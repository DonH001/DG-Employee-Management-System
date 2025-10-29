<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Repositories\EmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\LeaveRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $employeeRepository;
    protected $attendanceRepository;
    protected $leaveRequestRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        AttendanceRepository $attendanceRepository,
        LeaveRequestRepository $leaveRequestRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->leaveRequestRepository = $leaveRequestRepository;
    }

    public function admin()
    {
        try {
            $employeeStats = $this->employeeRepository->getDashboardStats();
            $attendanceStats = $this->attendanceRepository->getDashboardStats();
            $leaveStats = $this->leaveRequestRepository->getDashboardStats();

            $stats = array_merge($employeeStats, $attendanceStats, $leaveStats);

            $recentEmployees = Employee::with(['position'])
                ->latest()
                ->take(5)
                ->get();

            // Get today's attendance records for the view
            $attendanceStats = Attendance::with(['employee.user'])
                ->where('date', now()->format('Y-m-d'))
                ->orderBy('time_in', 'desc')
                ->get();

            return view('admin.dashboard', compact('stats', 'recentEmployees', 'attendanceStats'));
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error: ' . $e->getMessage());
            
            // Fallback stats
            $stats = [
                'total_employees' => Employee::count(),
                'active_employees' => Employee::where('employment_status', 'active')->count(),
                'present_today' => 0,
                'total_attendance_today' => 0,
                'pending_leave_requests' => 0,
                'total_leave_requests' => 0,
            ];
            
            $recentEmployees = collect([]);
            $attendanceStats = collect([]);

            return view('admin.dashboard', compact('stats', 'recentEmployees', 'attendanceStats'));
        }
    }

    public function hr()
    {
        $employeeStats = $this->employeeRepository->getDashboardStats();
        $attendanceStats = $this->attendanceRepository->getDashboardStats();
        $leaveStats = $this->leaveRequestRepository->getDashboardStats();

        $stats = array_merge($employeeStats, $attendanceStats, $leaveStats);

        $pendingLeaveRequests = $this->leaveRequestRepository->getPendingLeaveRequests()->take(5);
        $upcomingLeaves = $this->leaveRequestRepository->getExpiringSoon(30)->take(5);

        return view('hr.dashboard', compact('stats', 'pendingLeaveRequests', 'upcomingLeaves'));
    }

    public function employee()
    {
        try {
            $employee = Auth::user()->employee;
            
            if (!$employee) {
                return redirect()->route('profile.edit')->with('error', 'Please complete your employee profile.');
            }

            $stats = [
                'total_attendance_this_month' => $employee->attendances()
                    ->whereMonth('date', now()->month)
                    ->count(),
                'total_hours_this_month' => $employee->attendances()
                    ->whereMonth('date', now()->month)
                    ->sum('total_hours'),
                'pending_leave_requests' => $employee->leaveRequests()->where('status', 'pending')->count(),
                'approved_leave_requests' => $employee->leaveRequests()
                    ->where('status', 'approved')
                    ->where('start_date', '>=', now())
                    ->count(),
            ];

            $recentAttendance = $this->attendanceRepository->getRecentAttendance($employee->id, 5);
            $recentLeaveRequests = $this->leaveRequestRepository->getEmployeeLeaveRequests($employee->id)->take(5);

            return view('employee.dashboard', compact('stats', 'recentAttendance', 'recentLeaveRequests', 'employee'));
        } catch (\Exception $e) {
            \Log::error('Employee dashboard error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}