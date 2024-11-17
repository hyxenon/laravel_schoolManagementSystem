<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleStudent extends Model
{
    use HasFactory;

    // If you have additional attributes, specify them here
    protected $fillable = [
        'schedule_id',
        'student_id',
        // Add any other attributes if necessary
    ];

    /**
     * Get the schedule associated with this record.
        */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the student associated with this record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
