<div class="container py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Colleges</h2>
        <button type="button" wire:click="openAddDepartmentModal" class="inline-flex items-center px-4 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg gap-x-2 hover:bg-blue-700">
            Add Department
        </button>
    </div>

    @foreach($departments as $department)
        <div class="mb-6 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between px-6 py-4">
                <h3 class="text-lg font-semibold">{{ $department->name }}</h3>

                <!-- Edit Button -->
                <button class="text-indigo-600 hover:text-indigo-800" wire:click="editDepartment({{ $department->id }})">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3614 2.48148C18.2874 1.40754 16.5463 1.40753 15.4723 2.48148L13.9325 4.0213L6.68531 11.2684C6.56783 11.3859 6.4845 11.5332 6.4442 11.6943L5.52753 15.361C5.44943 15.6734 5.54096 16.0038 5.76865 16.2314C5.99633 16.4591 6.32678 16.5507 6.63916 16.4726L10.3058 15.5559C10.467 15.5156 10.6142 15.4323 10.7317 15.3148L17.9261 8.12038L19.5187 6.52784C20.5926 5.4539 20.5926 3.71269 19.5187 2.63876L19.3614 2.48148ZM16.7687 3.77784C17.1266 3.41987 17.707 3.41987 18.065 3.77784L18.2223 3.93511C18.5803 4.2931 18.5803 4.87351 18.2223 5.23148L17.2905 6.16329L15.8647 4.68179L16.7687 3.77784ZM14.5681 5.97838L15.9939 7.45989L9.6149 13.8389L7.67667 14.3235L8.16121 12.3853L14.5681 5.97838ZM3.66683 7.3333C3.66683 6.82704 4.07724 6.41663 4.5835 6.41663H9.16683C9.6731 6.41663 10.0835 6.00623 10.0835 5.49997C10.0835 4.99371 9.6731 4.5833 9.16683 4.5833H4.5835C3.06472 4.5833 1.8335 5.81452 1.8335 7.3333V17.4166C1.8335 18.9354 3.06472 20.1666 4.5835 20.1666H14.6668C16.1857 20.1666 17.4168 18.9354 17.4168 17.4166V12.8333C17.4168 12.3271 17.0064 11.9166 16.5002 11.9166C15.9939 11.9166 15.5835 12.3271 15.5835 12.8333V17.4166C15.5835 17.9229 15.1731 18.3333 14.6668 18.3333H4.5835C4.07724 18.3333 3.66683 17.9229 3.66683 17.4166V7.3333Z" fill="#4741A6"/>
                        </svg>
                        
                </button>
            </div>

            <!-- Courses List -->
            <div class="px-6 py-4">
                <ul class="pl-5 space-y-2 list-disc">
                    @foreach($department->courses as $course)
                        <li class="text-gray-600">
                            <strong>{{ $course->name }}</strong> <br>
                            <span class="text-sm">{{ $course->description }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach

<!-- Modal -->
@if($showModal)
<div class="fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-md p-6 mx-4 space-y-6 bg-white rounded-lg shadow-xl sm:max-w-lg sm:mx-0">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ $isEdit ? 'Edit Department' : 'Add Department' }}
            </h3>
            <button wire:click="closeModal" class="p-1 text-gray-600 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit.prevent="{{ $isEdit ? 'updateDepartment' : 'createDepartment' }}">
            <!-- Department Name -->
            <div class="flex flex-col space-y-1">
                <label for="departmentName" class="text-sm font-medium text-gray-600">Department Name</label>
                <input type="text" wire:model="departmentName" id="departmentName" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter department name" required>
                @error('departmentName') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Department Description -->
            <div class="flex flex-col mt-4 space-y-1">
                <label for="departmentDescription" class="text-sm font-medium text-gray-600">Description</label>
                <textarea wire:model="departmentDescription" id="departmentDescription" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter department description" rows="4" required></textarea>
                @error('departmentDescription') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Program Head ID (Optional) -->
            <div class="flex flex-col mt-4 space-y-1">
                <label for="programHeadId" class="text-sm font-medium text-gray-600">Program Head ID (Optional)</label>
                <input type="text" wire:model="programHeadId" id="programHeadId" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter program head ID (if applicable)">
                @error('programHeadId') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

          
            <div class="flex justify-between mt-6 space-x-3">
                
                @if($isEdit)
                <button type="button" wire:click="confirmDelete" class="px-5 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-red-600 rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Department
                </button>
                @endif

                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="closeModal" class="px-5 py-2 text-sm text-gray-600 transition-all duration-200 ease-in-out bg-gray-200 rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-blue-600 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ $isEdit ? 'Save Changes' : 'Add Department' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif


@if (session()->has('message'))
    <div id="toast" class="fixed px-4 py-4 text-white transition-transform bg-green-500 rounded-lg shadow-lg bottom-4 right-4 transform-gpu">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('message') }}
        </div>
    </div>

    
    <script>
        setTimeout(function() {
            document.getElementById('toast').remove();
        }, 2000);
    </script>
@endif


</div>
