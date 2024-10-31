<x-professor-layout>
    <h1 class="text-lg font-bold">Grades for {{ $student->user->name ?? 'No Name' }}</h1>

    <div class="container mx-auto mt-8 p-4">
        <!-- Prelim Grades -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-2xl font-bold mb-4">Prelim Grades</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-2">Activity</th>
                        <th class="py-2">Score</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prelimGrades as $grade)
                        <tr>
                            <td>{{ $grade->assignment->title }}</td>
                            <td>{{ $grade->grade_value }}</td>
                            <td>
                                <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="grade_value" value="{{ $grade->grade_value }}" required>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Midterm Grades -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-2xl font-bold mb-4">Midterm Grades</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-2">Activity</th>
                        <th class="py-2">Score</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($midtermGrades as $grade)
                        <tr>
                            <td>{{ $grade->assignment->title }}</td>
                            <td>{{ $grade->grade_value }}</td>
                            <td>
                                <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="grade_value" value="{{ $grade->grade_value }}" required>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
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
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finalGrades as $grade)
                        <tr>
                            <td>{{ $grade->assignment->title }}</td>
                            <td>{{ $grade->grade_value }}</td>
                            <td>
                                <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="grade_value" value="{{ $grade->grade_value }}" required>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Overall Grade (if needed) -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-2xl font-bold mb-4">Overall Grade</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-2">Assessment</th>
                        <th class="py-2">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2">Prelim</td>
                        <td class="py-2">{{ $prelimGrades->avg('grade_value') ?? 'No Grade' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Midterm</td>
                        <td class="py-2">{{ $midtermGrades->avg('grade_value') ?? 'No Grade' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Final</td>
                        <td class="py-2">{{ $finalGrades->avg('grade_value') ?? 'No Grade' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-professor-layout>
