<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'department_id',
        'position',
        'category',
        'salary',
    ];

    // Relationships

    /**
     * Get the department that the employee belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user that is associated with the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all courses taught by the employee.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_employee');
    }

    /**
     * Get all departments led by the employee.
     */
    public function departmentsLed()
    {
        return $this->hasMany(Department::class, 'head_of_department_id');
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
