<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    // Disable the automatic timestamps behavior
    public $timestamps = false;

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'meeting',
        'start_time',
        'end_time',
        'date',
        'status',
        'department',
        'expected_attendees',
        'requested_by',
        'added_at', // Add 'added_at' here
    ];

    // Optionally, you can define custom date formats for any date fields
    protected $dates = [
        'date',
        'added_at',
    ];

    // Accessor for formatting the start_time
    public function getStartTimeFormattedAttribute()
    {
        return Carbon::parse($this->start_time)->format('g:i A');
    }

    // Accessor for formatting the end_time
    public function getEndTimeFormattedAttribute()
    {
        return Carbon::parse($this->end_time)->format('g:i A');
    }

    // Accessor for formatting the date
    public function getDateFormattedAttribute()
    {
        return Carbon::parse($this->date)->format('m/d/Y');
    }

    // Optionally, you can add an accessor for the 'added_at' field
    public function getAddedAtFormattedAttribute()
    {
        return Carbon::parse($this->added_at)->format('m/d/Y h:i A');
    }

    // Boot method to automatically set the added_at timestamp when an event is created
    protected static function boot()
    {
        parent::boot();

        // Automatically set the 'added_at' timestamp when creating a new event
        static::creating(function ($event) {
            if (!$event->added_at) {
                $event->added_at = Carbon::now(); // Set the current time if added_at is not provided
            }
        });
    }
}
