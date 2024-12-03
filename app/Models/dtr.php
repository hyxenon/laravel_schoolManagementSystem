<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dtr extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's naming conventions)
    protected $table = 'dtr';

    // Define fillable fields for mass assignment
    protected $fillable = [
            'user_id',
            'department_id',
            'position',
            'category',
            'salary',
            'name',
            'date',
            'clock_in',
            'clocked_out',
            'behavior',
            'status',
            'workshift',
    ];

    // Relationship with Employee: A DTR belongs to one Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class,  'department_id');
    }

    public $timestamps = true;
}
