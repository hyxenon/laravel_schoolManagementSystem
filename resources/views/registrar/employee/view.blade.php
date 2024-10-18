<x-registrar-layout>

<div class="p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800">Employee Details</h2>

    <div class="mt-4">
        <p><strong>ID:</strong> {{ $employee->id }}</p>
        <p><strong>Name:</strong> {{ $employee->user->name }}</p>
        <p><strong>Email:</strong> {{ $employee->user->email }}</p>
        <p><strong>Position:</strong> {{ ucwords(str_replace('_', ' ', $employee->position)) }}</p>
        
    </div>

    <div class="mt-6">
        <a href="{{ route('registrar.employee.registrar') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Back to Employee List</a>
    </div>
</div>
</x-registrar-layout>

