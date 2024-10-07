<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'department_id',
        'description',
    ];

    // Relationships

    /**
     * Get the department that the course belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get all students enrolled in the course.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get all subjects that are part of the course.
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get all teachers assigned to this course.
     */
    public function teachers()
    {
        return $this->belongsToMany(Employee::class, 'course_employee');
    }
}
