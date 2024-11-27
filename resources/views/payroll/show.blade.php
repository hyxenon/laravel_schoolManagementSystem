<x-registrar-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Payroll Details</h1>

    @if(session('success'))
        <div class="mb-6 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            <div>
                <strong>Employee:</strong> {{ $payroll->employee->name }}
            </div>
            <div>
                <strong>Amount:</strong> {{ number_format($payroll->amount, 2) }}
            </div>
            <div>
                <strong>Payment Date:</strong> {{ $payroll->payment_date->format('Y-m-d') }}
            </div>
            <div>
                <strong>Status:</strong> {{ $payroll->status }}
            </div>
            <div>
                <strong>Remarks:</strong> {{ $payroll->remarks }}
            </div>
        </div>
    </div>
</x-registrar-layout>
