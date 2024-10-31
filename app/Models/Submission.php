<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submitted_at',
        'file_path',
        'grade',
        'remarks',
    ];

    // Relationships

    /**
     * Get the assignment that this submission belongs to.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student who submitted the assignment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    
}

