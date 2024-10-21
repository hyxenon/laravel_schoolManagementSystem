<div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-md">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Add Subject</h2>
    
    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Subject Name -->
        <div class="flex flex-col">
            <label for="subjectName" class="text-sm font-medium text-gray-700">Subject Name</label>
            <input type="text" wire:model="subjectName" id="subjectName" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter subject name" required>
        </div>

        <!-- Subject Code -->
        <div class="flex flex-col">
            <label for="subjectCode" class="text-sm font-medium text-gray-700">Subject Code</label>
            <input type="text" wire:model="subjectCode" id="subjectCode" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter subject code" required>
        </div>

        <!-- Credits -->
        <div class="flex flex-col">
            <label for="credits" class="text-sm font-medium text-gray-700">Credits</label>
            <input type="number" wire:model="credits" id="credits" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter credits" required>
        </div>

        <!-- Description -->
        <div class="flex flex-col">
            <label for="description" class="text-sm font-medium text-gray-700">Description (optional)</label>
            <textarea wire:model="description" id="description" rows="3" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter description"></textarea>
        </div>

        <!-- Department Dropdown -->
        <div class="flex flex-col">
            <label for="department" class="text-sm font-medium text-gray-700">Department</label>
            <select wire:model="selectedDepartment" wire:change="updateCourses" id="department" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Department</option>
                <option value="general">General Subject</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Courses Dropdown (only shows if not a general subject) -->
        @if($selectedDepartment && $selectedDepartment !== 'general')
            <div class="flex flex-col">
                <label for="course" class="text-sm font-medium text-gray-700">Course</label>
                <select wire:model="selectedCourse" id="course" class="w-full px-4 py-3 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full px-4 py-2 text-white transition duration-150 ease-in-out bg-blue-600 rounded-lg hover:bg-blue-700">Add Subject</button>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif
</div>
