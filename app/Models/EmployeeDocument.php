<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_name',
        'document_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'expiry_date',
        'is_confidential',
        'uploaded_by',
        'notes',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_confidential' => 'boolean',
        'file_size' => 'integer',
    ];

    /**
     * Get the employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Check if document is expired
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if document is expiring soon (within 30 days)
     */
    public function isExpiringSoon()
    {
        return $this->expiry_date && $this->expiry_date->isBetween(now(), now()->addDays(30));
    }

    /**
     * Scope a query to only include confidential documents.
     */
    public function scopeConfidential($query)
    {
        return $query->where('is_confidential', true);
    }

    /**
     * Scope a query to filter by document type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('document_type', $type);
    }
}