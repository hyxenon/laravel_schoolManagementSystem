<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'employee_id',
        'schedule_id',
        'date',
        'status',
    ];

    // Relationships

    /**
     * Get the student that the attendance record belongs to.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the employee that the attendance record belongs to.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the schedule that the attendance record is for.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
