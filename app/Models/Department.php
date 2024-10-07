<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'description',
        'head_of_department_id',
    ];

    // Relationships

    /**
     * Get the head of the department (an employee).
     */
    public function headOfDepartment()
    {
        return $this->belongsTo(Employee::class, 'head_of_department_id');
    }

    /**
     * Get all courses that belong to the department.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get all employees that belong to the department.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get all students that belong to the department.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Course::class);
    }
}
