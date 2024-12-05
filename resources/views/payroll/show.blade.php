<x-registrar-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Payroll Details</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <strong>Employee:</strong> {{ $payroll->employee->name }}
        </div>
        <div class="mb-4">
            <strong>Amount:</strong> {{ number_format($payroll->amount, 2) }}
        </div>
        <div class="mb-4">
            <strong>Payment Date:</strong> {{ $payroll->payment_date->format('Y-m-d') }}
        </div>
        <div class="mb-4">
            <strong>Status:</strong> {{ ucfirst($payroll->status) }}
        </div>
        <div class="mb-4">
            <strong>Remarks:</strong> {{ $payroll->remarks }}
        </div>
    </div>
</x-registrar-layout>
