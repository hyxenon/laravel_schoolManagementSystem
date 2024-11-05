<x-treasury-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasury Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class=" p-5 bg-white">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">TREASURY</h1>
        </div>

        <form action="{{ route('treasury.payment.store') }}" method="POST">
            @csrf
            <div class="form-section mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="student-id" class="block font-semibold mb-1">Student ID</label>
                        <input type="text" name="student_id" id="student-id" placeholder="Enter Student ID" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="student-name" class="block font-semibold mb-1">Student Name</label>
                        <input type="text" id="student-name" placeholder="Auto-filled after inputting Student ID" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="document-type" class="block font-semibold mb-1">Type of Document</label>
                        <select name="document_type" id="document-type" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Choose the type of document</option>
                            <option value="tor">Transcript of Records</option>
                            <option value="coe">Certificate of Enrollment</option>
                            <option value="tuition">Tuition Fee</option>
                            <option value="id">ID</option>
                        </select>
                    </div>
                    <div>
                        <label for="exam-type" class="block font-semibold mb-1">Type of Exam</label>
                        <select name="exam_type" id="exam-type" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Choose the type of exam</option>
                            <option value="prelims">Prelims</option>
                            <option value="midterm">Midterm</option>
                            <option value="final">Final</option>
                            <option value="summer">Summer</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-gray-300">

            <div class="payment-section mb-4">
                <h2 class="text-xl font-bold text-blue-800 mb-3">PAYMENT INFORMATION</h2>

                <div class="payment-form mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="payment-method" class="block font-semibold mb-1">Select a payment method</label>
                            <select name="payment_method" id="payment-method" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">--select--</option>
                                <option value="over-the-counter">Over the Counter</option>
                            </select>
                        </div>            
                        <div>
                            <label for="payment-amount" class="block font-semibold mb-1">Enter Payment Amount</label>
                            <input type="text" name="amount" id="payment-amount" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Amount" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="payment-date" class="block font-semibold mb-1">Payment Date</label>
                            <input type="date" name="payment_date" id="payment-date" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="security-code" class="block font-semibold mb-1">Security Code</label>
                            <input type="text" name="security_code" id="security-code" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Security Code" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-32 mx-auto py-2 text-center bg-blue-800 text-white rounded hover:bg-blue-700 transition duration-300">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
</x-treasury-layout> 