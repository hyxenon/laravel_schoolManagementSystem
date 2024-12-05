<x-program_head-layout>
    <div class="container py-8 mx-auto">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Create Schedule</h1>

        <!-- Display General Errors -->
        @if($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('schedules.store') }}" method="POST" class="p-6 space-y-4 bg-white border border-gray-200 rounded-lg shadow-md">
            @csrf

            <!-- Subject Selection -->
            <div>
                <label for="subject_id" class="block mb-1 text-sm font-medium text-gray-700">Subject:</label>
                <select name="subject_id" id="subject_id" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teacher Selection -->
            <div>
                <label for="employee_id" class="block mb-1 text-sm font-medium text-gray-700">Professor:</label>
                <select name="employee_id" id="employee_id" class="block w-full p-2 border border-gray-300 rounded-lg choices-select focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('employee_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                    @endforeach
                </select>
                @error('employee_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Room Selection -->
            <div>
                <label for="room_id" class="block mb-1 text-sm font-medium text-gray-700">Room:</label>
                <select name="room_id" id="room_id" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Year and Block input --}}

                        <!-- Year Input -->
                        <div>
                            <label for="year" class="block mb-1 text-sm font-medium text-gray-700">Year:</label>
                            <input type="number" name="year" id="year" value="{{ old('year') }}" min="1" max="4" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

            <div>
                <label for="block" class="block mb-1 text-sm font-medium text-gray-700">Block:</label>
                <input type="number" name="block" id="block" value="{{ old('block') }}" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('block')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        


            <!-- Day of the Week Selection -->
            <div>
                <label for="day_of_week" class="block mb-1 text-sm font-medium text-gray-700">Day:</label>
                <select name="day_of_week" id="day_of_week" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Monday" {{ old('day_of_week') == 'Monday' ? 'selected' : '' }}>Monday</option>
                    <option value="Tuesday" {{ old('day_of_week') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="Wednesday" {{ old('day_of_week') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="Thursday" {{ old('day_of_week') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="Friday" {{ old('day_of_week') == 'Friday' ? 'selected' : '' }}>Friday</option>
                    <option value="Saturday" {{ old('day_of_week') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                    <option value="Sunday" {{ old('day_of_week') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Time -->
            <div>
                <label for="start_time" class="block mb-1 text-sm font-medium text-gray-700">Start Time:</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Time -->
            <div>
                <label for="end_time" class="block mb-1 text-sm font-medium text-gray-700">End Time:</label>
                <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Save
            </button>
        </form>
    </div>

    <!-- Initialize Choices.js -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.choices-select');
            elements.forEach((element) => {
                new Choices(element, {
                    placeholderValue: 'Select Professor',
                    searchEnabled: true,
                    removeItemButton: true
                });
            });
        });
    </script>
</x-program_head-layout>
