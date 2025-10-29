<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Repositories\LeaveRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    protected $leaveRequestRepository;

    public function __construct(LeaveRequestRepository $leaveRequestRepository)
    {
        $this->leaveRequestRepository = $leaveRequestRepository;
    }

    public function index(Request $request)
    {
        $leaveRequests = $this->leaveRequestRepository->getPaginatedLeaveRequests($request, 10);
        return view('admin.leave-requests.index', compact('leaveRequests'));
    }

    public function employeeIndex()
    {
        $employee = Auth::user()->employee;
        $leaveRequests = $this->leaveRequestRepository->getPaginatedEmployeeLeaveRequests($employee->id, 10);

        return view('employee.leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        return view('employee.leave-requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:sick,vacation,personal,maternity,paternity',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        $employee = Auth::user()->employee;

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Clear leave request cache
        $this->leaveRequestRepository->clearCache($employee->id);

        return redirect()->route('employee.leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Clear leave request cache
        $this->leaveRequestRepository->clearCache($leaveRequest->employee_id);

        return redirect()->back()
            ->with('success', 'Leave request approved successfully.');
    }

    public function reject(LeaveRequest $leaveRequest, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Clear leave request cache
        $this->leaveRequestRepository->clearCache($leaveRequest->employee_id);

        return redirect()->back()
            ->with('success', 'Leave request rejected.');
    }
}