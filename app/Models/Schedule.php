<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'subject_id',
        'room_id',
        'employee_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    // Relationships

    /**
     * Get the subject that this schedule belongs to.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the room that this schedule is assigned to.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the teacher (employee) that is assigned to this schedule.
     */
    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get all students assigned to this schedule.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'schedule_student');
    }

    public function subject()
{
    return $this->belongsTo(Subject::class, 'subject_id');
}
}
