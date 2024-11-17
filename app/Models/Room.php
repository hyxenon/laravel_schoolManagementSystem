<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'building_id',
        'capacity',
    ];

    // Relationships


    public function building()
    {
        return $this->belongsTo(Building::class);
    }


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
