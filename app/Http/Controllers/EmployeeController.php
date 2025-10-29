<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $request)
    {
        $employees = $this->employeeRepository->getPaginatedEmployees($request, 15);
        $departments = Department::active()->get();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $positions = Position::active()->get();

        return view('admin.employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'hire_date' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'role' => 'required|in:admin,hr,employee',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Default password
            'role' => $validated['role'],
        ]);

        // Generate employee ID
        $lastEmployee = Employee::latest('id')->first();
        $nextId = $lastEmployee ? (int)substr($lastEmployee->employee_id, 3) + 1 : 1;
        $employeeId = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Get default department (first available department)
        $defaultDepartment = Department::first();
        
        // Create employee record
        $employee = Employee::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'department_id' => $defaultDepartment->id ?? 1, // Use default department
            'position_id' => $validated['position_id'],
            'manager_id' => null, // No manager assignment
            'hire_date' => $validated['hire_date'],
            'employment_type' => $validated['employment_type'],
            'salary' => $validated['salary'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
        ]);

        // Clear employee cache
        $this->employeeRepository->clearCache();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully. Default password is: password123');
    }

    public function show(Employee $employee)
    {
        $employee = $this->employeeRepository->getEmployeeById($employee->id);
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::active()->get();

        return view('admin.employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->user_id)],
            'phone' => 'nullable|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'employment_status' => 'required|in:active,inactive,terminated,on_leave',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'role' => 'required|in:admin,hr,employee',
        ]);

        // Update user account
        $employee->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Update employee record
        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'position_id' => $validated['position_id'],
            'employment_status' => $validated['employment_status'],
            'employment_type' => $validated['employment_type'],
            'salary' => $validated['salary'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
        ]);

        // Clear employee cache
        $this->employeeRepository->clearCache($employee->id);

        return redirect()->route('admin.employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Soft delete by updating employment status
        $employee->update([
            'employment_status' => 'terminated',
            'termination_date' => now(),
        ]);

        // Deactivate user account
        $employee->user->update(['is_active' => false]);

        // Clear employee cache
        $this->employeeRepository->clearCache($employee->id);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee terminated successfully.');
    }
}