<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'client_name',
        'status',
        'priority',
        'start_date',
        'end_date',
        'deadline',
        'budget',
        'actual_cost',
        'project_manager_id',
        'technologies',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'budget' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'technologies' => 'array',
    ];

    /**
     * Get the project manager.
     */
    public function projectManager()
    {
        return $this->belongsTo(Employee::class, 'project_manager_id');
    }

    /**
     * Get all project assignments.
     */
    public function assignments()
    {
        return $this->hasMany(ProjectAssignment::class);
    }

    /**
     * Get all assigned employees through assignments.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_assignments')
                    ->withPivot('role', 'assigned_date', 'unassigned_date', 'hourly_rate', 'is_active')
                    ->withTimestamps();
    }

    /**
     * Get all time entries for this project.
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Get budget utilization percentage
     */
    public function getBudgetUtilizationAttribute()
    {
        if (!$this->budget || $this->budget == 0) {
            return 0;
        }
        return ($this->actual_cost / $this->budget) * 100;
    }

    /**
     * Check if project is overbudget
     */
    public function isOverBudget()
    {
        return $this->budget && $this->actual_cost > $this->budget;
    }

    /**
     * Get total hours worked on project
     */
    public function getTotalHoursAttribute()
    {
        return $this->timeEntries()->sum('hours_worked') ?? 0;
    }

    /**
     * Scope a query to only include active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}