<div>
    <h1 class="mb-8 text-3xl font-bold text-gray-600">
        Employees {{ $selectedPosition === 'All' ? '' : ucwords(str_replace('_', ' ', $selectedPosition)) }}
    </h1>
    
    <select wire:change="filterByPosition($event.target.value)" class="max-w-[200px] px-4 py-3 mb-8 text-sm border-gray-200 rounded-lg pe-9 focus:border-blue-500 focus:ring-blue-500">
        <option value="All">All</option>
        <option value="registrar">Registrar</option>
        <option value="treasury">Treasury</option>
        <option value="teacher">Professor</option>
        <option value="program_head">Program Head</option>
    </select>
    
    

      <div class="p-6 bg-white rounded-lg shadow">
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
                <button wire:click="openAddUserModal" class="px-6 py-2 text-white bg-[#4741A6] rounded-lg ">
                    + Add User
                </button>

    </div>



    <!-- Employees Table -->
    <div class="my-8 overflow-auto border border-gray-200 rounded-lg shadow-lg">
        <table class="w-full bg-white divide-y divide-gray-200">
            <thead class="bg-[#9BBBFC]">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left ">ID</th>
                    <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left ">Name</th>
                    <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left ">Email</th>
                    <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left ">Position</th>
                    <th class="px-6 py-3 text-xs font-semibold tracking-wider text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($employees as $employee)
                    <tr wire:key="employee-{{ $employee->id }}" class="transition duration-150 ease-in-out hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $employee->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">{{ ucwords($employee->user->name) ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $employee->user->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 capitalize whitespace-nowrap">{{ucwords(str_replace('_', ' ', $employee->position)) }}</td>
                        <td  class="px-6 py-4 text-center whitespace-nowrap">

                            <a href="{{ route('employee.show', $employee->id) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-green-600 bg-green-100 rounded-full hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-300">
                                View
                            </a>
                            <button wire:click="edit({{ $employee->id }})" class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Edit
                            </button>
                            <button wire:click="confirmDelete({{ $employee->id }})" class="inline-flex items-center px-3 py-1.5 ml-2 text-sm font-semibold text-red-600 bg-red-100 rounded-full hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
        
        @if($selectedPosition === "All")
            <!-- Show all options if "All" is selected -->
            <option value="registrar">Registrar</option>
            <option value="teacher">Teacher</option>
            <option value="program_head">Program Head</option>
            <option value="treasury">Treasury</option>
        @elseif($selectedPosition === "registrar")
            <option value="registrar">Registrar</option>
        @elseif($selectedPosition === "teacher")
            <option value="teacher">Teacher</option>
        @elseif($selectedPosition === "program_head")
            <option value="program_head">Program Head</option>
        @elseif($selectedPosition === "treasury")
            <option value="treasury">Treasury</option>
        @endif
    </select>
    @error('position') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
</div>



<!-- Password and Confirmation Fields (only for Add User) -->
@unless($isEdit)
    <div class="flex flex-col">
        <label for="password" class="mb-1 text-sm font-medium text-gray-600">Password</label>
        <div class="flex items-center">
            <input type="password" wire:model.defer="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password">
        </div>
        @error('password') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col">
        <label for="password_confirmation" class="mb-1 text-sm font-medium text-gray-600">Confirm Password</label>
        <input type="password" wire:model.defer="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Confirm Password">
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
</div>



