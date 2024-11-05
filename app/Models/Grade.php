<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'subject_id',
        'grade_value',
        'term',
    ];

    // Relationships

    /**
     * Get the student that owns the grade.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject that this grade is for.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
