<x-program_head-layout>
    <div class="container max-w-3xl py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-900">Edit Schedule</h1>

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

        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="p-6 space-y-6 bg-white border border-gray-200 shadow-lg rounded-xl">
            @csrf
            @method('PUT')

            <!-- Subject Selection -->
            <div>
                <label for="subject_id" class="block mb-1 text-sm font-medium text-gray-700">Subject:</label>
                <select name="subject_id" id="subject_id" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
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
                        <option value="{{ $teacher->id }}" {{ $schedule->employee_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
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
                        <option value="{{ $room->id }}" {{ $schedule->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Day of the Week Selection -->
            <div>
                <label for="day_of_week" class="block mb-1 text-sm font-medium text-gray-700">Day:</label>
                <select name="day_of_week" id="day_of_week" class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Monday" {{ $schedule->day_of_week == 'Monday' ? 'selected' : '' }}>Monday</option>
                    <option value="Tuesday" {{ $schedule->day_of_week == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="Wednesday" {{ $schedule->day_of_week == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="Thursday" {{ $schedule->day_of_week == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="Friday" {{ $schedule->day_of_week == 'Friday' ? 'selected' : '' }}>Friday</option>
                    <option value="Saturday" {{ $schedule->day_of_week == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                    <option value="Sunday" {{ $schedule->day_of_week == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="space-y-2">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time:</label>
                <input type="time" name="start_time" id="start_time" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('H:i') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Time -->
            <div class="space-y-2">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time:</label>
                <input type="time" name="end_time" id="end_time" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('H:i') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>
</x-program_head-layout>
