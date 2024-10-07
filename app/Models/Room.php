<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment

    // name: Represents the name or number of the room (e.g., "Room 101").
    // building: Represents the building where the room is located (e.g., "Main Building").
    // capacity: Represents the number of students or people the room can accommodate.
    protected $fillable = [
        'name',
        'building',
        'capacity',
    ];

    // Relationships

    /**
     * Get all schedules that are assigned to the room.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
