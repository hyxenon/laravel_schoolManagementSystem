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
        'amount',
        'payment_date',
        'document_type',
        'security_code',
        'payment_method',
        'status',
        'remark'
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
