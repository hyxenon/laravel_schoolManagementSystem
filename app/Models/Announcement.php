<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    // target_audience: Defines the audience for the announcement (e.g., "students", "faculty", "all").
    protected $fillable = [
        'title',
        'content',
        'target_audience',
        'published_at',
    ];

    // Relationships

    /**
     * Get the employee who created the announcement.
     */
    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
