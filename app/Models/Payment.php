<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'document_type',
        'payment_method',
        'amount',
        'payment_date',
        'exam_type',
        'status',
        'remarks',
        'operator', // Add operator here
    ];

    // Relationships

    /**
     * Get the student that the payment belongs to.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
