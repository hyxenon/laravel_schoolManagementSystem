<x-professor-layout>
<h1 class="text-lg font-bold">Grades for {{ $student->name }}</h1>

<div class="container mx-auto mt-8 p-4">
    <!-- Prelim Grades -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-bold mb-4">Prelim Grades</h2>
        <table class="table-auto w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">Activity</th>
                    <th class="py-2">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    @php
                        // Find submission for this assignment by the selected student
                        $submission = $assignment->submissions->firstWhere('student_id', $student->id);
                    @endphp
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>
                            @if($submission)
                                {{ $submission->grade }} <!-- Display the grade -->
                            @else
                                No Submission
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

 {{--   <!-- Midterm Grades -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-bold mb-4">Midterm Grades</h2>
        <table class="table-auto w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">Activity</th>
                    <th class="py-2">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($midtermGrades as $grade)
                <tr class="border-t">
                    <td class="py-2">{{ $grade->subject->name ?? 'N/A' }}</td> <!-- Assuming subject has a name property -->
                    <td class="py-2">{{ $grade->grade_value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Final Grades -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-bold mb-4">Final Grades</h2>
        <table class="table-auto w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">Activity</th>
                    <th class="py-2">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finalGrades as $grade)
                <tr class="border-t">
                    <td class="py-2">{{ $grade->subject->name ?? 'N/A' }}</td> <!-- Assuming subject has a name property -->
                    <td class="py-2">{{ $grade->grade_value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Overall Grade -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-bold mb-4">Final/Overall Grade</h2>
        <table class="table-auto w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">Assessment</th>
                    <th class="py-2">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr class="border-t">
                    <td class="py-2">{{ $grade->term }}</td>
                    <td class="py-2">{{ $grade->grade_value }}</td>
                </tr>
                @endforeach
                <tr class="border-t font-bold">
                    <td class="py-2">Semester Grade</td>
                    <td class="py-2">{{ $semesterGrade }}</td>
                </tr>
            </tbody>
        </table>
    </div>--}}
</div>
</x-professor-layout>