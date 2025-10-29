<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'department_id',
        'min_salary',
        'max_salary',
        'requirements',
        'level',
        'is_active',
    ];

    protected $casts = [
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'requirements' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that owns the position.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get all employees with this position.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get salary range as formatted string
     */
    public function getSalaryRangeAttribute()
    {
        if ($this->min_salary && $this->max_salary) {
            return '$' . number_format($this->min_salary) . ' - $' . number_format($this->max_salary);
        }
        return 'Not specified';
    }

    /**
     * Scope a query to only include active positions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}