<div class="container py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">Subjects</h2>
        <button type="button" wire:click="openModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Add Subject
        </button>
    </div>


<!-- Department Dropdown -->
<select wire:model="selectedDepartment" wire:change="filterByDepartment($event.target.value)" class="max-w-xs px-4 py-3 mb-8 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
    <option value="all">All Subjects</option>
    <option value="general">General Subjects</option>
    @foreach($departments as $department)
        <option value="{{ $department->id }}">{{ $department->name }}</option>
    @endforeach
</select>

{{-- Courses Dropdown - will show only if a specific department is selected and not general --}}
@if($selectedDepartment && $selectedDepartment !== 'all' && $selectedDepartment !== 'general')
    @if($courses && count($courses) > 0)
        <select wire:model="selectedCourse" wire:change="filterByCourse($event.target.value)" class="max-w-xs px-4 py-3 mb-8 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    @endif
@endif




 <!-- Subjects Table -->
 <div class="flex flex-col px-4 py-8 mt-4 bg-white border rounded-xl">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                @if($subjects && count($subjects) > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Subject Code</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Subject Name</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Course</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @foreach($subjects as $subject)
                                <tr wire:key="subject-{{ $subject->id }}" class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-neutral-200">{{ $subject->code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">{{ $subject->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                        {{ $subject->course ? $subject->course->name : 'General Subject' }}
                                    </td>
                                    <td class="flex items-center gap-4 px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                        <!-- Edit Button -->
                                        <button 
                                            wire:click="edit({{ $subject->id }})" 
                                            class="flex items-center gap-1 p-2 text-blue-600 transition duration-150 ease-in-out rounded-md hover:text-blue-700 focus:text-blue-800 focus:outline-none hover:bg-blue-100"
                                            title="Edit Subject"
                                        >
                                            <span>Edit</span>
                                        </button>
                        
                                        <!-- Delete Button -->
                                        <button 
                                            wire:click="confirmDelete({{ $subject->id }})" 
                                            class="flex items-center gap-1 p-2 text-red-600 transition duration-150 ease-in-out rounded-md hover:text-red-700 focus:text-red-800 focus:outline-none hover:bg-red-100"
                                            title="Delete Subject"
                                        >
                                            <span>Delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                @else
                    <div class="px-6 py-4 text-center text-gray-500">
                        No subjects found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if($showDeleteModal)
    <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 overflow-auto bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete this subject? This action cannot be undone.</p>
            <div class="flex justify-end gap-4">
                <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                <button wire:click="delete" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
@endif


<!-- Modal for Adding/Editing Subject -->
@if($showModal)
<div class="fixed inset-0 z-[70] overflow-auto flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg md:p-8 sm:max-w-lg lg:max-w-md">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $editMode ? 'Edit Subject' : 'Add Subject' }}
            </h2>
            <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form wire:submit.prevent="save" class="space-y-4">
            <!-- ... (form fields for subject data) ... -->
            
            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    {{ $editMode ? 'Update Subject' : 'Save Subject' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif


    <!-- Modal for Adding Subject -->
    @if($showModal)
    <div class="fixed inset-0 z-[70] overflow-auto flex items-center justify-center p-4 bg-black bg-opacity-50">
        <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg md:p-8 sm:max-w-lg lg:max-w-md">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b">
                <h2 class="text-2xl font-bold text-gray-800">Add Subject</h2>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form wire:submit.prevent="save" class="space-y-4">
                <!-- Subject Name -->
                <div>
                    <label for="subjectName" class="text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" wire:model="subjectName" id="subjectName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter subject name" required>
                    @error('subjectName') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Subject Code (Unique Validation) -->
                <div>
                    <label for="subjectCode" class="text-sm font-medium text-gray-700">Subject Code</label>
                    <input type="text" wire:model="subjectCode" id="subjectCode" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter subject code" required>
                    @error('subjectCode') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Credits -->
                <div>
                    <label for="credits" class="text-sm font-medium text-gray-700">Credits</label>
                    <input type="number" wire:model="credits" id="credits" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter credits" required>
                    @error('credits') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="text-sm font-medium text-gray-700">Description (optional)</label>
                    <textarea wire:model="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter description"></textarea>
                </div>

                <!-- Department Dropdown -->
                <div>
                    <label for="department" class="text-sm font-medium text-gray-700">Department</label>
                    <select wire:model="selectedDepartment" wire:change="updateCourses" id="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Department</option>
                        <option value="general">General Subject</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedDepartment') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Courses Dropdown (only shows if not a general subject) -->
                @if($selectedDepartment && $selectedDepartment !== 'general')
                    <div>
                        <label for="course" class="text-sm font-medium text-gray-700">Course</label>
                        <select wire:model="selectedCourse" id="course" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedCourse') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Save Subject</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Success Message -->
    @if (session()->has('message'))
        <div id="toast" class="fixed px-4 py-2 text-white bg-green-500 rounded-lg bottom-4 right-4">
            {{ session('message') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('toast').remove(), 2000);
        </script>
    @endif
</div>
