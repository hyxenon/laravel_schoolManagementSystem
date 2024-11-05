<?php

namespace App\Livewire;


use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\User;

class RegistrarEmployeeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $employeeId, $name, $email, $position;
    public $showModal = false;
    protected $queryString = ['search'];
    public $isEdit = false;
    public $password;
    public $password_confirmation;
    public $showDeleteModal = false;
    public $employeeToDelete;
    public $employeeName;

    public $selectedPosition = 'All';


    public function openAddUserModal()
    {
        $this->resetInputFields();
        $this->password = '';
        $this->password_confirmation = '';
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'position' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);


        $category = ($this->position === 'teacher' || $this->position === 'program_head') ? 'faculty' : 'staff';


        $user->employee()->create([
            'position' => $this->position,
            'category' => $category,
            'salary' => 0
        ]);


        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'User added successfully.');
    }


    public function updatingSearch()
    {
        $this->resetPage();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $this->resetInputFields();
        $this->isEdit = true;
        $this->showModal = true;

        $employee = Employee::findOrFail($id);
        $this->employeeId = $employee->id;
        $this->name = $employee->user->name;
        $this->email = $employee->user->email;
        $this->position = $employee->position;
    }

    public function update()
    {
        $employee = Employee::findOrFail($this->employeeId);
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->user_id), // Use user_id here instead of employeeId
            ],
            'position' => 'required|string|max:255',
        ]);

        $employee = Employee::findOrFail($this->employeeId);
        $user = User::findOrFail($employee->user_id);
        $user->update(['name' => $this->name, 'email' => $this->email]);
        $employee->update(['position' => $this->position]);

        $this->resetInputFields();
        $this->showModal = false;
        session()->flash('message', 'Employee updated successfully.');
    }


    public function closeModal()
    {
        $this->resetInputFields();
        $this->showModal = false;
    }

    private function resetInputFields()
    {
        $this->employeeId = null;
        $this->name = '';
        $this->email = '';
        $this->position = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function confirmDelete($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employeeToDelete = $id;
        $this->employeeName = $employee->user->name;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $employee = Employee::findOrFail($this->employeeToDelete);
        $employee->user->delete();

        $this->showDeleteModal = false;
        $this->employeeToDelete = null;
        session()->flash('message', 'Employee deleted successfully.');
    }

    public function filterByPosition($position)
    {
        $this->selectedPosition = $position;
        $this->resetPage(); // Optional: resets pagination to page 1 when filtering
    }


    public function render()
    {
        $employees = Employee::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        // Apply position filter if not "All"
        if ($this->selectedPosition !== 'All') {
            $employees->where('position', $this->selectedPosition);
        }

        return view('livewire.registrar-employee-table', [
            'employees' => $employees->paginate(10),
        ]);
    }
}
