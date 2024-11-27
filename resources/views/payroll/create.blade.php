<x-registrar-layout>
    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Create New Payroll</h1>
    </div>

    <!-- Create Payroll Form -->
    <div class="w-full max-w-full mx-auto bg-white p-8 rounded-lg shadow-md">
        <form action="{{ route('payroll.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Employee Name -->
                <div class="mb-4">
                    <label for="employee_name" class="block text-sm font-medium text-gray-700">Employee</label>
                    <input type="text" id="employee_name" name="employee_name" class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full" placeholder="Enter employee name" required>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" id="amount" name="amount" class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full" step="0.01" placeholder="Enter amount" required>
                </div>

                <!-- Payment Date -->
                <div class="mb-4">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date" class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full" required>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full">
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>

                <!-- Remarks -->
                <div class="mb-4 col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea id="remarks" name="remarks" class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full" rows="4" placeholder="Enter any remarks"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-right">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                    Create Payroll
                </button>
            </div>
        </form>
    </div>
</x-registrar-layout>
