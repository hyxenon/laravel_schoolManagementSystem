<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'employee_id',
        'amount',
        'payment_date',
        'status',
        'remarks',
    ];

    // Relationships

    /**
     * Get the employee that the payroll belongs to.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
