<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'date_of_birth',
        'gender',
        'marital_status',
        'social_security_number',
        'department_id',
        'position_id',
        'manager_id',
        'hire_date',
        'termination_date',
        'employment_status',
        'employment_type',
        'salary',
        'pay_frequency',
        'profile_photo',
        'skills',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'salary' => 'decimal:2',
        'skills' => 'array',
    ];

    /**
     * Get the user that owns the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that owns the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that owns the employee.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the manager of the employee.
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get all subordinates of the employee.
     */
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * Get all time entries for the employee.
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Get all project assignments for the employee.
     */
    public function projectAssignments()
    {
        return $this->hasMany(ProjectAssignment::class);
    }

    /**
     * Get all leave requests for the employee.
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Get all documents for the employee.
     */
    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Get all attendance records for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all projects where this employee is the project manager.
     */
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }

    /**
     * Get formatted salary attribute
     */
    public function getFormattedSalaryAttribute()
    {
        return $this->salary ? '$' . number_format($this->salary, 2) : 'Not specified';
    }

    /**
     * Get years of service attribute
     */
    public function getYearsOfServiceAttribute()
    {
        return $this->hire_date->diffInYears(now());
    }

    /**
     * Check if employee is active
     */
    public function isActive()
    {
        return $this->employment_status === 'active';
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('employment_status', 'active');
    }

    /**
     * Scope a query to filter by department.
     */
    public function scopeInDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }
}