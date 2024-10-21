<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;

class Subjects extends Component
{
    public $departments;       // Stores all departments
    public $courses = [];      // Stores courses based on selected department
    public $selectedDepartment; // Holds the selected department
    public $selectedCourse;    // Holds the selected course (if applicable)
    public $subjectName;       // Holds the subject name
    public $subjectCode;       // Holds the subject code
    public $credits;           // Holds the credits
    public $description;       // Holds the description

    public function mount()
    {
        // Fetch all departments
        $this->departments = Department::all();
    }

    public function updateCourses()
    {
        // Check if the selected department is a general subject
        if ($this->selectedDepartment === 'general') {
            $this->courses = []; // No courses if general subject
            $this->selectedCourse = null; // Reset selected course
        } else {
            // Fetch courses based on the selected department
            $this->courses = Course::where('department_id', $this->selectedDepartment)->get();
            $this->selectedCourse = null; // Reset selected course when department changes
        }
    }

    public function save()
    {
        $this->validate([
            'subjectName' => 'required|string|max:255',
            'subjectCode' => 'required|string|max:50',
            'credits' => 'required|integer',
            'selectedDepartment' => 'required',  // department selection validation
        ]);

        // Save the subject
        Subject::create([
            'name' => $this->subjectName,
            'code' => $this->subjectCode,
            'credits' => $this->credits,
            'description' => $this->description,
            'course_id' => $this->selectedCourse,  // can be null if general subject
        ]);

        session()->flash('message', 'Subject successfully added.');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->subjectName = '';
        $this->subjectCode = '';
        $this->credits = '';
        $this->description = '';
        $this->selectedDepartment = null;
        $this->selectedCourse = null;
    }

    public function render()
    {
        return view('livewire.subjects');
    }
}
