<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Validation\Rule;

class Subjects extends Component
{
    public $departments;        // Stores all departments
    public $courses = [];       // Stores courses based on selected department
    public $selectedDepartment = 'all'; // Holds the selected department (default is 'all')
    public $selectedCourse;     // Holds the selected course (if applicable)
    public $subjectName;        // Holds the subject name
    public $subjectCode;        // Holds the subject code
    public $credits;            // Holds the credits
    public $description;        // Holds the description
    public $showModal = false;  // Controls modal visibility

    public $subjects;

    public function mount()
    {
        // Fetch all departments
        $this->departments = Department::all();
        $this->subjects = $this->getSubjectsProperty(); // Load initial subjects
        $this->courses = []; // Default value para maiwasan ang null
    }


    public function openModal()
    {
        $this->resetForm();  // Clear the form when opening
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateCourses()
    {
        if ($this->selectedDepartment === 'general') {
            $this->courses = []; // Walang kurso kung general subject
            $this->selectedCourse = null; // I-reset ang napiling kurso
        } elseif ($this->selectedDepartment !== 'all') {
            $this->courses = Course::where('department_id', $this->selectedDepartment)->get();
            $this->selectedCourse = null; // I-reset ang napiling kurso kapag nagbago ang departamento
        } else {
            $this->courses = []; // Walang kurso kung "All Subjects"
        }
    }


    public function save()
    {
        $this->validate([
            'subjectName' => 'required|string|max:255',
            'subjectCode' => ['required', 'string', 'max:50', Rule::unique('subjects', 'code')],
            'credits' => 'required|integer',
            'selectedDepartment' => 'required',
        ]);

        Subject::create([
            'name' => $this->subjectName,
            'code' => $this->subjectCode,
            'credits' => $this->credits,
            'description' => $this->description,
            'course_id' => $this->selectedCourse,
        ]);

        session()->flash('message', 'Subject successfully added.');
        $this->closeModal();
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->subjectName = '';
        $this->subjectCode = '';
        $this->credits = '';
        $this->description = '';
        $this->selectedDepartment = 'all';
        $this->selectedCourse = null;
    }

    public function filterByDepartment($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->selectedCourse = null; // I-reset ang selected course kapag nagbago ang department
        $this->updateCourses();

        // Update subjects based on selected department
        $this->subjects = $this->getSubjectsProperty();
    }


    public function filterByCourse($courseId)
    {
        $this->selectedCourse = $courseId;

        if ($this->selectedCourse) {
            // Kung may napiling course, ifilter lang sa course na iyon
            $this->subjects = Subject::with('course')
                ->where('course_id', $this->selectedCourse)
                ->get();
        } else {
            // Kung walang specific course, kuhanin lahat ng subjects ng department
            $this->filterByDepartment($this->selectedDepartment);
        }
    }

    public function getSubjectsProperty()
    {
        $query = Subject::with('course'); // Add eager loading for the course

        if ($this->selectedDepartment === 'general') {
            // General subjects lamang, walang course_id
            $query->whereNull('course_id');
        } elseif ($this->selectedDepartment !== 'all') {
            // Kung may napiling department ngunit walang course
            $query->whereHas('course', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            });

            if ($this->selectedCourse) {
                // Kung may napiling course sa department
                $query->where('course_id', $this->selectedCourse);
            }
        }

        // Kung "all" ang napili, walang filter sa department at course.
        return $query->get();
    }








    public function render()
    {
        return view('livewire.subjects', [
            'subjects' => $this->subjects,
        ]);
    }
}
