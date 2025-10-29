<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function employees(Request $request)
    {
        $query = Employee::with(['user', 'position']);

        // Filter by employment status
        if ($request->status) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->get();

        return view('admin.reports.employees', compact('employees'));
    }

    public function attendance(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $query = Attendance::with(['employee.user'])
            ->whereBetween('date', [$startDate, $endDate]);

        // Filter by employee
        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $attendanceRecords = $query->orderBy('date', 'desc')->get();

        // Calculate totals
        $totalHours = $attendanceRecords->sum('total_hours');
        $totalRecords = $attendanceRecords->count();
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $lateDays = $attendanceRecords->where('status', 'late')->count();
        $absentDays = $attendanceRecords->where('status', 'absent')->count();

        // Group by employee for summary
        $employeeSummary = $attendanceRecords->groupBy('employee_id')->map(function ($records) {
            return [
                'employee' => $records->first()->employee,
                'total_hours' => $records->sum('total_hours'),
                'total_days' => $records->count(),
                'present_days' => $records->where('status', 'present')->count(),
                'late_days' => $records->where('status', 'late')->count(),
                'absent_days' => $records->where('status', 'absent')->count(),
                'average_hours' => $records->count() > 0 ? round($records->sum('total_hours') / $records->count(), 2) : 0,
            ];
        });

        $employees = Employee::with('user')->where('employment_status', 'active')->get();

        return view('admin.reports.attendance', compact(
            'attendanceRecords',
            'employeeSummary',
            'employees',
            'totalHours',
            'totalRecords',
            'presentDays',
            'lateDays',
            'absentDays',
            'startDate',
            'endDate'
        ));
    }
}