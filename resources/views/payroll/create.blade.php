<x-registrar-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Add New Payroll</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add Payroll Form -->
    <form action="{{ route('payroll.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
            <select name="employee_id" id="employee_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div>
            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            </select>
        </div>

        <div>
            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
            <textarea name="remarks" id="remarks" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('remarks') }}</textarea>
        </div>

        <button type="submit" class="w-full px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Payroll</button>
    </form>
</x-registrar-layout>
