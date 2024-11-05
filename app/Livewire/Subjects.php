<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Validation\Rule;

class Subjects extends Component
{
    public $departments;
    public $courses = [];
    public $selectedDepartment = 'all';
    public $selectedCourse;
    public $subjectName;
    public $subjectCode;
    public $credits;
    public $description;
    public $showModal = false;

    public $subjects;
    public $editMode = false;
    public $subjectId;


    public $showDeleteModal = false;
    public $subjectToDelete;

    public function mount()
    {
        $this->departments = Department::all();
        $this->subjects = $this->getSubjectsProperty();
        $this->courses = [];
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateCourses()
    {
        if ($this->selectedDepartment === 'general') {
            $this->courses = [];
            $this->selectedCourse = null;
        } elseif ($this->selectedDepartment !== 'all') {
            $this->courses = Course::where('department_id', $this->selectedDepartment)->get();
        } else {
            $this->courses = [];
        }
    }

    public function edit($id)
    {
        $this->editMode = true;
        $this->subjectId = $id;
        $subject = Subject::findOrFail($id);

        $this->subjectName = $subject->name;
        $this->subjectCode = $subject->code;
        $this->credits = $subject->credits;
        $this->description = $subject->description;
        $this->selectedDepartment = $subject->course ? $subject->course->department_id : 'general';
        $this->selectedCourse = $subject->course_id;

        $this->updateCourses();
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->subjectToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->subjectToDelete) {
            $subject = Subject::findOrFail($this->subjectToDelete);
            $subject->delete();

            session()->flash('message', 'Subject successfully deleted.');
            $this->subjects = $this->getSubjectsProperty();

            $this->subjectToDelete = null;
        }
        $this->showDeleteModal = false;
    }

    public function save()
    {
        $this->validate([
            'subjectName' => 'required|string|max:255',
            'subjectCode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('subjects', 'code')->ignore($this->subjectId)
            ],
            'credits' => 'required|integer',
            'selectedDepartment' => 'required',
        ]);

        $data = [
            'name' => $this->subjectName,
            'code' => $this->subjectCode,
            'credits' => $this->credits,
            'description' => $this->description,
            'course_id' => $this->selectedCourse,
        ];

        if ($this->editMode) {
            $subject = Subject::findOrFail($this->subjectId);
            $subject->update($data);
            session()->flash('message', 'Subject successfully updated.');
        } else {
            Subject::create($data);
            session()->flash('message', 'Subject successfully added.');
        }

        $this->closeModal();
        $this->resetForm();
        $this->subjects = $this->getSubjectsProperty();
    }

    public function resetForm()
    {
        $this->subjectName = '';
        $this->subjectCode = '';
        $this->credits = '';
        $this->description = '';
        $this->selectedDepartment = 'all';
        $this->selectedCourse = null;
        $this->editMode = false;
        $this->subjectId = null;
    }

    public function getSubjectsProperty()
    {
        $query = Subject::with('course');

        if ($this->selectedDepartment === 'general') {
            $query->whereNull('course_id');
        } elseif ($this->selectedDepartment !== 'all') {
            $query->whereHas('course', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            });

            if ($this->selectedCourse) {
                $query->where('course_id', $this->selectedCourse);
            }
        }

        return $query->get();
    }

    public function filterByDepartment($departmentId)
    {
        $this->selectedDepartment = $departmentId;
        $this->selectedCourse = null;
        $this->updateCourses();
        $this->subjects = $this->getSubjectsProperty();
    }

    public function filterByCourse($courseId)
    {
        $this->selectedCourse = $courseId;

        if ($this->selectedCourse) {

            $this->subjects = Subject::with('course')
                ->where('course_id', $this->selectedCourse)
                ->get();
        } else {

            $this->subjects = $this->getSubjectsProperty();
        }
    }



    public function render()
    {
        return view('livewire.subjects', [
            'subjects' => $this->subjects,
        ]);
    }
}
