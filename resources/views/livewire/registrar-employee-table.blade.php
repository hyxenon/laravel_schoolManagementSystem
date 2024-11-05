<div>
    <h1 class="text-3xl font-bold text-gray-800">
        Employees {{ $selectedPosition === 'All' ? '' : '- ' . ucwords(str_replace('_', ' ', $selectedPosition)) }}
    </h1>


    


      <div class="p-6 mt-8 bg-white rounded-lg shadow">
        <!-- Flash Message -->
        @if(session()->has('message'))
        <div class="p-4 mb-4 rounded-md bg-green-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <select wire:model="selectedPosition" wire:change="filterByPosition($event.target.value)" class="w-full px-4 py-2 border-gray-300 rounded-lg sm:w-48 focus:border-blue-500 focus:ring-blue-500">
            <option value="All">All Positions</option>
            <option value="registrar">Registrar</option>
            <option value="treasury">Treasury</option>
            <option value="teacher">Professor</option>
            <option value="program_head">Program Head</option>
        </select>
        
        <div class="flex w-full gap-2 sm:w-auto">
            <input type="text" wire:model.live.debounce.300ms="search" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search employees...">
            <button wire:click="openAddUserModal" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                + Add User
            </button>
        </div>
    </div>



    <!-- Employees Table -->
    <div class="mt-8 overflow-auto bg-white rounded-lg shadow-md">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Position</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($employees as $employee)
                    <tr wire:key="employee-{{ $employee->id }}" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $employee->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ ucwords($employee->user->name) ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $employee->user->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 capitalize whitespace-nowrap">{{ ucwords(str_replace('_', ' ', $employee->position)) }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a href="{{ route('employee.show', $employee->id) }}" class="mr-2 text-blue-600 hover:text-blue-900">View</a>
                            <button wire:click="edit({{ $employee->id }})" class="mr-2 text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="confirmDelete({{ $employee->id }})" class="text-red-600 hover:text-red-900">Delete</button>
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
<div class="fixed inset-0 z-[80] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Confirm Deletion
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this employee <strong>{{ $employeeName }}</strong>? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" wire:click="delete" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
                <button type="button" wire:click="$set('showDeleteModal', false)" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif
</div>
</div>



