<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define a one-to-one relationship with the Employee model.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Check if the user has a registrar role.
     *
     * @return bool
     */
    public function isRegistrar()
    {
        return $this->employee && $this->employee->position === 'Registrar';
    }

    /**
     * Check if the user has a teacher role.
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->employee && $this->employee->position === 'Teacher';
    }

    /**
     * Check if the user is a student (no employee record).
     *
     * @return bool
     */
    public function isStudent()
    {
        return !$this->employee;
    }
}
