<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;

class Departments extends Component
{
    public $departments;
    public $departmentId, $departmentName, $departmentDescription, $programHeadId;
    public $showModal = false;
    public $isEdit = false;

    // Course fields
    public $courseId, $courseName, $courseDescription, $showCourseModal = false, $isCourseEdit = false;
    public $showDeleteCourseModal = false;
    public $showDeleteDepartmentModal = false;
    public $departmentIdToDelete;



    public function render()
    {
        $this->departments = Department::with('courses')->get();
        return view('livewire.departments');
    }


    public function openAddDepartmentModal()
    {
        $this->resetInputFields();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function createDepartment()
    {
        $this->validate([
            'departmentName' => 'required',
            'departmentDescription' => 'required',
            'programHeadId' => 'nullable|integer|exists:employees,id',
        ], [
            'programHeadId.exists' => 'The Program Head ID does not exist in the employees database.'
        ]);

        Department::create([
            'name' => $this->departmentName,
            'description' => $this->departmentDescription,
            'head_of_department_id' => $this->programHeadId,
        ]);


        if ($this->programHeadId) {
            Employee::where('id', $this->programHeadId)->update(['position' => 'program_head']);
        }

        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'Department added successfully.');
    }



    public function editDepartment($id)
    {
        $this->resetInputFields();
        $this->isEdit = true;
        $this->showModal = true;

        $department = Department::findOrFail($id);
        $this->departmentId = $department->id;
        $this->departmentName = $department->name;
        $this->departmentDescription = $department->description;
        $this->programHeadId = $department->head_of_department_id;
    }

    public function updateDepartment()
    {
        $this->validate([
            'departmentName' => 'required',
            'departmentDescription' => 'required',
            'programHeadId' => [
                'nullable',
                'integer',
                'exists:employees,id', // This ensures the programHeadId exists in the employees table
            ],
        ]);


        $department = Department::findOrFail($this->departmentId);


        if ($department->head_of_department_id && $department->head_of_department_id != $this->programHeadId) {

            $oldHead = Employee::find($department->head_of_department_id);
            if ($oldHead) {
                $oldHead->update(['position' => 'teacher']);
            }
        }


        $department->update([
            'name' => $this->departmentName,
            'description' => $this->departmentDescription,
            'head_of_department_id' => $this->programHeadId,
        ]);


        if ($this->programHeadId) {
            $newHead = Employee::find($this->programHeadId);
            if ($newHead) {
                $newHead->update(['position' => 'program_head']);
            }
        }

        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'Department updated successfully.');
    }




    public function confirmDelete()
    {

        $department = Department::findOrFail($this->departmentId);
        $this->departmentIdToDelete = $department->id;
        $this->departmentName = $department->name;
        $this->showDeleteDepartmentModal = true;
    }

    public function deleteDepartment()
    {

        Department::findOrFail($this->departmentIdToDelete)->delete();


        $this->showDeleteDepartmentModal = false;
        $this->showModal = false;
        $this->resetInputFields();



        session()->flash('message', 'Department deleted successfully.');
    }

    public function closeDeleteDepartmentModal()
    {
        $this->showDeleteDepartmentModal = false;
    }

    // Course methods
    public function openAddCourseModal($departmentId)
    {
        $this->resetCourseInputFields();
        $this->departmentId = $departmentId;
        $this->isCourseEdit = false;
        $this->showCourseModal = true;
    }

    public function createCourse()
    {
        $this->validate([
            'courseName' => 'required',
            'courseDescription' => 'required',
        ]);

        Course::create([
            'name' => $this->courseName,
            'description' => $this->courseDescription,
            'department_id' => $this->departmentId,
        ]);

        $this->resetCourseInputFields();
        $this->showCourseModal = false;
        session()->flash('message', 'Course added successfully.');
    }

    public function editCourse($courseId)
    {
        $this->resetCourseInputFields();
        $this->isCourseEdit = true;
        $this->showCourseModal = true;

        $course = Course::findOrFail($courseId);
        $this->courseId = $course->id;
        $this->courseName = $course->name;
        $this->courseDescription = $course->description;
        $this->departmentId = $course->department_id;
    }

    public function updateCourse()
    {
        $this->validate([
            'courseName' => 'required',
            'courseDescription' => 'required',
        ]);

        $course = Course::findOrFail($this->courseId);
        $course->update([
            'name' => $this->courseName,
            'description' => $this->courseDescription,
        ]);

        $this->resetCourseInputFields();
        $this->showCourseModal = false;
        session()->flash('message', 'Course updated successfully.');
    }

    public function confirmCourseDelete($id)
    {
        $course = Course::findOrFail($id);
        $this->courseId = $course->id;
        $this->courseName = $course->name;
        $this->showDeleteCourseModal = true;
    }

    public function deleteCourse()
    {
        Course::findOrFail($this->courseId)->delete();
        $this->showDeleteCourseModal = false;
        session()->flash('message', 'Course deleted successfully.');
    }

    public function closeDeleteCourseModal()
    {
        $this->showDeleteCourseModal = false;
    }




    public function closeModal()
    {
        $this->resetInputFields();
        $this->showModal = false;
    }

    public function closeCourseModal()
    {
        $this->resetCourseInputFields();
        $this->showCourseModal = false;
    }


    private function resetInputFields()
    {
        $this->departmentId = null;
        $this->departmentName = '';
        $this->departmentDescription = '';
        $this->programHeadId = null;
    }

    private function resetCourseInputFields()
    {
        $this->courseId = null;
        $this->courseName = '';
        $this->courseDescription = '';
        $this->departmentId = null;
    }
}
