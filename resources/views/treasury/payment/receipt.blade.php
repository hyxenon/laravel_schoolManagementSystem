<x-treasury-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto my-10 p-5 bg-white shadow-md rounded-lg">
        <div class="text-center mb-6">
            <img src="{{ asset('images/schoolLogo.svg')}}" alt="Logo" class="w-16 mx-auto mb-2">
            <h1 class="text-xl font-bold text-gray-800">International State College of the Philippines</h1>
            <p class="text-gray-600 text-sm">{{ date('D, M d, Y • h:i:s A', strtotime($payment->payment_date)) }}</p>
        </div>

        <div class="text-center mb-6">
            <p class="text-sm font-semibold">Token</p>
            <div class="border border-dashed border-gray-800 p-2 rounded-lg font-bold">{{ $payment->token }}</div>
        </div>

        <hr class="my-4 border-gray-300">

        <div class="mb-4">
            <p class="text-gray-600"><strong>Student Name:</strong> {{ $payment->student->name }}</p>
            <p class="text-gray-600"><strong>Student ID:</strong> {{ $payment->student_id }}</p>
        </div>

        <hr class="my-4 border-gray-300">

        <div class="mb-4">
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Method:</span>
                <span class="text-gray-600">{{ $payment->payment_method }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Document Type:</span>
                <span class="text-gray-600">{{ $payment->document_type }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Amount:</span>
                <span class="text-gray-600">{{ number_format($payment->amount, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tax:</span>
                <span class="text-gray-600">{{ number_format($payment->tax, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span class="text-gray-600">Total:</span>
                <span class="text-gray-600">{{ number_format($payment->total, 2) }}</span>
            </div>
        </div>

        <hr class="my-4 border-gray-300">

        <div class="flex justify-between">
            <p class="text-gray-600">Operator:</p>
            <p class="text-gray-600">{{ $operator->name ?? 'Treasury 1' }}</p>
        </div>


        <div class="text-center mt-6">
            <button class="bg-blue-800 text-white rounded py-2 px-4 hover:bg-blue-700">Print Receipt</button>
        </div>
    </div>
</body>
</html>
</x-treasury-layout>
