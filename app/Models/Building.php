<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',  // Building name, e.g., "Main Building"
    ];


    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
