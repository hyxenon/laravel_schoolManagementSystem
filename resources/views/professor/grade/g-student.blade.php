<x-professor-layout>
    <div class="container mx-auto mt-8 p-4 bg-white">
        <h1 class="text-lg font-bold">PROFESSOR</h1>

        <div class="container mx-auto mt-8 p-4">
            <!-- Student List -->
            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <h2 class="text-2xl font-bold mb-4">Student List</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="text-left">
                                <th class="py-2">Name</th>
                                <th class="py-2">Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($students->isEmpty())
                                <tr>
                                    <td colspan="3" class="py-2 text-center">No students found for this subject.</td>
                                </tr>
                            @else
                                @foreach($students as $student)
                                <tr class="border-t">
                                    <td class="py-2 flex items-center">
                                        <img class="w-8 h-8 rounded-full mr-2" src="https://via.placeholder.com/100" alt="Student">
                                        <a href="{{ route('grades.grade', [$schedule->subject_id, $student->id]) }}">
                                            {{ $student->user->name ?? 'No Name' }}
                                        </a>
                                    </td>
                                    <td class="py-2">{{ $student->course->name ?? 'No Course' }} {{ $student->year_level }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-professor-layout>
