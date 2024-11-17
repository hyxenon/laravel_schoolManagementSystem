<x-professor-layout>
<div class="container mx-auto mt-8 p-4 bg-white">
    <h1 class="text-lg font-bold">PROFESSOR</h1>

    <!-- Content -->
    <div class="container mx-auto mt-8 p-4">
        <!-- Subject List -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-2xl font-bold mb-4">All Subjects</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-2">Subject</th>
                        <th class="py-2">Subject Code</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                @if($subjects->isEmpty())
                    <tr>
                        <td colspan="3" class="py-2 text-center">No subjects found for this teacher.</td>
                    </tr>
                @else
                    @foreach($subjects as $subject)
                        <tr class="border-t">
                            <td class="py-2"><a href="{{ route('grades.student', $subject->id) }}">{{ $subject->name }}</a></td>
                            <td class="py-2">{{ $subject->code }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
        </div>
    </div>
    
</x-professor-layout></div>