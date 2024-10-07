<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'employee_id',
        'due_date',
    ];

    // Relationships

    /**
     * Get the subject that this assignment belongs to.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher (employee) who created this assignment.
     */
    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get all submissions for this assignment.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
