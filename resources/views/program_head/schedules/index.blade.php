<x-program_head-layout>
    <div class="container py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Schedules</h1>
            <a href="{{ route('schedules.create') }}" class="px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Create New Schedule
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead>
                    <tr class="">
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Subject</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Teacher</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Room</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Year</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Block</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Day</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Start Time</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">End Time</th>
                        <th class="px-4 py-3 text-sm font-medium text-left text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->subject->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->teacher->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->room->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->year }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->block }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->day_of_week }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->start_time }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border-b">{{ $schedule->end_time }}</td>
                            <td class="flex items-center gap-2 px-4 py-2 text-sm text-gray-800 border-b">
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-blue-600 transition hover:text-blue-800">
                                    Edit
                                </a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 transition hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-program_head-layout>
