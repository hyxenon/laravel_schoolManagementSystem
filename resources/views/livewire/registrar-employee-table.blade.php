<div class="p-6 overflow-auto bg-white rounded-lg shadow">
        <!-- Flash Message -->
        @if(session()->has('message'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" 
        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Search...">
                <!-- Add User Button -->
                <button wire:click="openAddUserModal" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                    + Add User
                </button>

    </div>



    <!-- Employees Table -->
    <table class="w-full border-collapse">
        <thead class="text-white bg-indigo-700">
            <tr>
                <th class="px-4 py-3 text-left">ID</th>
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Position</th>
                <th class="px-4 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr class="transition duration-150 ease-in-out hover:bg-gray-200">
                    <td class="px-4 py-3 border-b border-gray-200">{{ $employee->id }}</td>
                    <td class="px-4 py-3 border-b border-gray-200">{{ $employee->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 border-b border-gray-200">{{ $employee->user->email ?? 'N/A' }}</td>
                    <td class="px-4 py-3 capitalize border-b border-gray-200">{{ $employee->position }}</td>
                    <td class="px-4 py-3 text-center border-b border-gray-200">
                        <button wire:ignore wire:click="edit({{ $employee->id }})" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 010 4.243L7.5 17.207l-4.5 1.5 1.5-4.5 7.732-7.732a3 3 0 014.242 0z"></path></svg>
                            Edit
                        </button>
                        <button wire:ignore wire:click="confirmDelete({{ $employee->id }})" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.136 21H7.864a2 2 0 01-1.997-1.858L5 7m5 4v6m4-6v6M1 7h22"></path></svg>
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center border-b border-gray-200">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    

    <div class="mt-4 text-center">
        {{ $employees->links() }}
    </div>
    
<!-- Modal -->
@if($showModal)
<div class="fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-lg p-6 space-y-6 bg-white rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">
                {{ $isEdit ? 'Edit Employee' : 'Add User' }}
            </h3>
            <button wire:click="closeModal" class="p-2 text-gray-600 rounded-full hover:bg-gray-200 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="space-y-4">
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'saveUser' }}" class="space-y-4">
                <!-- Name Field -->
                <div class="flex flex-col">
                    <label for="name" class="mb-1 text-sm font-medium text-gray-600">Name</label>
                    <input type="text" wire:model="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Name">
                    @error('name') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div class="flex flex-col">
                    <label for="email" class="mb-1 text-sm font-medium text-gray-600">Email</label>
                    <input type="email" wire:model="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email">
                    @error('email') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                
<!-- Position Dropdown -->
<div class="flex flex-col">
    <label for="position" class="mb-1 text-sm font-medium text-gray-600">Position</label>
    <select wire:model="position" id="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Select Position</option>
        @if($isEdit)
            <!-- Show all options if editing -->
            <option value="registrar">Registrar</option>
            <option value="teacher">Teacher</option>
            <option value="program_head">Program Head</option>
            <option value="treasury">Treasury</option>
            <option value="student">Student</option>
        @else
            <!-- Show only Registrar option if adding -->
            <option value="registrar">Registrar</option>
        @endif
    </select>
    @error('position') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
</div>


                <!-- Password and Confirmation Fields (only for Add User) -->
                @unless($isEdit)
                <div class="flex flex-col" wire:ignore>
                    <label for="password" class="mb-1 text-sm font-medium text-gray-600">Password</label>
                    <div class="flex items-center">
                        <input type="password" wire:model="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password">

                       
                    </div>
                    @error('password') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label for="password_confirmation" class="mb-1 text-sm font-medium text-gray-600">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Confirm Password">
                    @error('password_confirmation') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                @endunless

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="closeModal" class="px-5 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        {{ $isEdit ? 'Save changes' : 'Add User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


<!-- Delete Confirmation Modal -->
@if($showDeleteModal)
<div class="fixed inset-0 z-[80] flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Confirm Deletion</h3>
            <button wire:click="$set('showDeleteModal', false)" class="p-1 text-gray-600 rounded-full hover:bg-gray-200 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="py-4">
            <p class="text-gray-700">Are you sure you want to delete this employee <strong>{{ $employeeName }}</strong>? This action cannot be undone.</p>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end mt-4 space-x-3">
            <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
            <button wire:click="delete" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>
@endif





    
</div>
