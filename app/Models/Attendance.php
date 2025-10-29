<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'break_duration',
        'total_hours',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'break_duration' => 'decimal:2',
        'total_hours' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateTotalHours()
    {
        if ($this->time_in && $this->time_out) {
            // Get the date as Y-m-d format
            $dateString = $this->date instanceof Carbon ? $this->date->format('Y-m-d') : $this->date;
            
            // Parse times with the date to ensure proper calculation
            $timeIn = Carbon::createFromFormat('Y-m-d H:i:s', $dateString . ' ' . $this->time_in);
            $timeOut = Carbon::createFromFormat('Y-m-d H:i:s', $dateString . ' ' . $this->time_out);
            
            // Handle overnight shifts
            if ($timeOut->lt($timeIn)) {
                $timeOut->addDay();
            }
            
            $totalMinutes = $timeOut->diffInMinutes($timeIn);
            $breakMinutes = ($this->break_duration ?? 0) * 60;
            $workMinutes = max(0, $totalMinutes - $breakMinutes);
            
            return round($workMinutes / 60, 2);
        }
        
        return 0;
    }

    public function updateTotalHours()
    {
        $this->total_hours = $this->calculateTotalHours();
        $this->save();
    }

    public function isLate($standardTimeIn = '09:00')
    {
        if ($this->time_in) {
            $standardTime = Carbon::createFromFormat('H:i', $standardTimeIn);
            $actualTime = Carbon::createFromFormat('H:i:s', $this->time_in);
            return $actualTime->gt($standardTime);
        }
        return false;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'green',
            'late' => 'yellow',
            'absent' => 'red',
            'half_day' => 'blue',
            default => 'gray'
        };
    }
}
