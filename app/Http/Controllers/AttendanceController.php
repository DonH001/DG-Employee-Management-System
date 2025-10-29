<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $employeeRepository;

    public function __construct(AttendanceRepository $attendanceRepository, EmployeeRepository $employeeRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $request)
    {
        $attendances = $this->attendanceRepository->getPaginatedAttendance($request, 20);
        return view('admin.attendance.index', compact('attendances'));
    }

    public function employeeIndex()
    {
        $employee = Auth::user()->employee;
        $attendances = $this->attendanceRepository->getPaginatedEmployeeAttendance($employee->id, 15);

        return view('employee.attendance.index', compact('attendances'));
    }

    public function clockIn(Request $request)
    {
        $employee = Auth::user()->employee;
        $today = Carbon::today()->format('Y-m-d');
        $currentTime = Carbon::now();

        // Check if already clocked in today
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->time_in) {
            return redirect()->back()->with('error', 'You have already clocked in today.');
        }

        // Create or update attendance record
        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => $today,
            ],
            [
                'time_in' => $currentTime->format('H:i:s'),
                'status' => $currentTime->format('H:i') > '09:00' ? 'late' : 'present',
            ]
        );

        // Clear attendance cache
        $this->attendanceRepository->clearCache($employee->id);

        // Log for debugging
        \Log::info('Clock In', [
            'employee_id' => $employee->id,
            'date' => $today,
            'time_in' => $currentTime->format('H:i:s'),
            'full_timestamp' => $currentTime->toDateTimeString(),
            'timezone' => config('app.timezone'),
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully at ' . $currentTime->format('g:i A') . ' on ' . $currentTime->format('M j, Y'));
    }

    public function clockOut(Request $request)
    {
        $employee = Auth::user()->employee;
        $today = Carbon::today()->format('Y-m-d');
        $currentTime = Carbon::now();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->time_in) {
            return redirect()->back()->with('error', 'You must clock in first.');
        }

        if ($attendance->time_out) {
            return redirect()->back()->with('error', 'You have already clocked out today.');
        }

        $attendance->update([
            'time_out' => $currentTime->format('H:i:s'),
            'break_duration' => $request->break_duration ?? 1, // Default 1 hour break
        ]);

        $attendance->updateTotalHours();

        // Clear attendance cache
        $this->attendanceRepository->clearCache($employee->id);

        // Log for debugging
        \Log::info('Clock Out', [
            'employee_id' => $employee->id,
            'date' => $today,
            'time_out' => $currentTime->format('H:i:s'),
            'full_timestamp' => $currentTime->toDateTimeString(),
            'total_hours' => $attendance->total_hours,
            'timezone' => config('app.timezone'),
        ]);

        return redirect()->back()->with('success', 'Clocked out successfully at ' . $currentTime->format('g:i A') . ' on ' . $currentTime->format('M j, Y'));
    }

    public function todayAttendance()
    {
        $employee = Auth::user()->employee;
        $attendance = $this->attendanceRepository->getTodayAttendance($employee->id);

        return response()->json([
            'attendance' => $attendance,
            'can_clock_in' => !$attendance || !$attendance->time_in,
            'can_clock_out' => $attendance && $attendance->time_in && !$attendance->time_out,
        ]);
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'break_duration' => 'nullable|numeric|min:0|max:8',
            'status' => 'required|in:present,absent,late,half_day',
            'notes' => 'nullable|string|max:500',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'date' => $request->date,
            ],
            [
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'break_duration' => $request->break_duration ?? 1,
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        if ($attendance->time_in && $attendance->time_out) {
            $attendance->updateTotalHours();
        }

        // Clear attendance cache
        $this->attendanceRepository->clearCache($request->employee_id);

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    public function report(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $query = Attendance::with(['employee.user'])
            ->whereBetween('date', [$startDate, $endDate]);

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        // Calculate summary statistics
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', '!=', 'absent')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $lateDays = $attendances->where('status', 'late')->count();
        $totalHours = $attendances->sum('total_hours');

        $employees = $this->employeeRepository->getActiveEmployees();

        return view('admin.attendance.report', compact(
            'attendances',
            'employees',
            'startDate',
            'endDate',
            'totalDays',
            'presentDays',
            'absentDays',
            'lateDays',
            'totalHours'
        ));
    }
}
