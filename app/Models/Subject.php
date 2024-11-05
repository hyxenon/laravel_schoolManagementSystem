<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'code',
        'course_id', // Optional for general subjects, nullable
        'credits',
        'description',
    ];

    // Relationships

    /**
     * Get the course that the subject belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }



    /**
     * Get all grades for the subject.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
