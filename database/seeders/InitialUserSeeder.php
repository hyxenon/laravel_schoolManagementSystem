<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Department for College of Engineering
        $engineeringDepartment = Department::create([
            'name' => 'College of Engineering and Computer Technology',
            'description' => 'College of Engineering and Computer Technology',
        ]);

        // Create Course for BSIT within CECT
        $bsitCourse = Course::create([
            'name' => 'BSIT',
            'description' => 'Bachelor of Science in Information Technology',
            'department_id' => $engineeringDepartment->id,
        ]);

        // Create a User (generic role)
        $user = User::create([
            'name' => 'Justine Edward P. Santos',
            'email' => 'justinesantos@gmail.com',
            'password' => Hash::make('testing123'),
        ]);

        // Create a Teacher User and Employee
        $teacherUser = User::create([
            'name' => 'Jose Rizal',
            'email' => 'teacher1@gmail.com',
            'password' => Hash::make('testing123'),
        ]);

        Employee::create([
            'user_id' => $teacherUser->id,
            'department_id' => $engineeringDepartment->id,
            'position' => 'reacher',
            'category' => 'faculty',
            'salary' => 45000.00, // Example salary
        ]);

        // Create a Registrar User and Employee
        $registrarUser = User::create([
            'name' => 'Apolinario Mabini',
            'email' => 'registrar1@gmail.com',
            'password' => Hash::make('testing123'),
        ]);

        Employee::create([
            'user_id' => $registrarUser->id,
            'department_id' => null, // Registrar does not belong to a department
            'position' => 'registrar',
            'category' => 'staff',
            'salary' => 50000.00, // Example salary
        ]);
    }
}
