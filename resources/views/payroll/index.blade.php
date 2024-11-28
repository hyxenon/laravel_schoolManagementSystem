<x-registrar-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Payroll List</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Payroll Button -->
    <div class="mb-6">
        <a href="{{ route('payroll.create') }}" class="inline-block px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            Add New Payroll
        </a>
    </div>

    <!-- Payroll Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto text-sm text-left text-gray-600">
            <thead class="bg-gray-200 text-xs font-medium text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 border-b">Employee</th>
                    <th class="px-4 py-2 border-b">Amount</th>
                    <th class="px-4 py-2 border-b">Payment Date</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Remarks</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $payroll)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $payroll->employee->name }}</td>
                        <td class="px-4 py-2">{{ number_format($payroll->amount, 2) }}</td>
                        <td class="px-4 py-2">{{ $payroll->payment_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 capitalize">{{ $payroll->status }}</td>
                        <td class="px-4 py-2">{{ $payroll->remarks }}</td>
                        <td class="px-4 py-2 flex items-center gap-2">
                            <a href="{{ route('payroll.edit', $payroll->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form action="{{ route('payroll.destroy', $payroll->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-registrar-layout>
