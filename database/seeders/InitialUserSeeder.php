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

        // Create a User (Student role)
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
            'position' => 'teacher',
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

        // Create a Program Head and Employee
        $programHeadUser = User::create([
            'name' => 'Jose Reyes',
            'email' => 'cecthead@gmail.com',
            'password' => Hash::make('testing123')
        ]);

        $programHeadEmployee = Employee::create([
            'user_id' => $programHeadUser->id,
            'department_id' => $engineeringDepartment->id,
            'position' => 'program_head',
            'category' => 'faculty',
            'salary' => 60000,
        ]);

        $engineeringDepartment->update([
            'head_of_department_id' => $programHeadEmployee->id
        ]);

        // Create a Treasury User
        $treasuryUser = User::create([
            'name' => 'Treasury First',
            'email' => 'treasury1@gmail.com',
            'password' => Hash::make('testing123')
        ]);

        Employee::create([
            'user_id' => $treasuryUser->id,
            'department_id' => null,
            'position' => 'treasury',
            'category' => 'staff',
            'salary' => 50000
        ]);
    }
}
