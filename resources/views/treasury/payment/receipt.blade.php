<x-treasury-layout>

    <div class="max-w-md p-5 mx-auto my-10 bg-white rounded-lg shadow-md">
        <div class="mb-6 text-center">
            <img src="{{ asset('images/schoolLogo.svg')}}" alt="Logo" class="w-16 mx-auto mb-2">
            <h1 class="text-xl font-bold text-gray-800">International State College of the Philippines</h1>
            <p class="text-sm text-gray-600">{{ date('D, M d, Y • h:i:s A', strtotime($payment->payment_date)) }}</p>
        </div>

        <div class="mb-6 text-center">
            <p class="text-sm font-semibold">Token</p>
            <div class="p-2 font-bold border border-gray-800 border-dashed rounded-lg">{{ $payment->token }}</div>
        </div>

        <hr class="my-4 border-gray-300">

        <div class="mb-4">
            <p class="text-gray-600"><strong>Student Name:</strong> {{ $student->name }}</p>
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
            <!-- <div class="flex justify-between">
                <span class="text-gray-600">Tax:</span>
                <span class="text-gray-600">{{ number_format($payment->tax, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span class="text-gray-600">Total:</span>
                <span class="text-gray-600">{{ number_format($payment->total, 2) }}</span>
            </div> -->
        </div>

        <hr class="my-4 border-gray-300">

        <div class="flex justify-between">
            <p class="text-gray-600">Operator:</p>
            <p class="text-gray-600">{{ $operator->name ?? 'Treasury 1' }}</p>
        </div>


        <div class="mt-6 text-center">
            <button class="px-4 py-2 text-white bg-blue-800 rounded hover:bg-blue-700">Print Receipt</button>
        </div>
    </div>

</x-treasury-layout> 

