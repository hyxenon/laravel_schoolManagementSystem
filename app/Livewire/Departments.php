<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class Departments extends Component
{
    public $departments;
    public $departmentId, $departmentName, $departmentDescription, $programHeadId;
    public $showModal = false;
    public $isEdit = false;

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
            'programHeadId' => 'nullable|integer',
        ]);

        Department::create([
            'name' => $this->departmentName,
            'description' => $this->departmentDescription,
            'head_of_department_id' => $this->programHeadId,
        ]);

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
            'programHeadId' => 'nullable|integer',
        ]);

        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->departmentName,
            'description' => $this->departmentDescription,
            'head_of_department_id' => $this->programHeadId,
        ]);

        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'Department updated successfully.');
    }


    public function confirmDelete()
    {
        $department = Department::findOrFail($this->departmentId);
        $department->delete();

        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'Department deleted successfully.');
    }


    public function closeModal()
    {
        $this->resetInputFields();
        $this->showModal = false;
    }


    private function resetInputFields()
    {
        $this->departmentId = null;
        $this->departmentName = '';
        $this->departmentDescription = '';
        $this->programHeadId = null;
    }
}
