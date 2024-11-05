<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student; // Ensure the Student model is imported
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('treasury.payment.create'); 
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'student_id' => 'required|string',
            'document_type' => 'required|string',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        // Create a new payment record
        $payment = new Payment();
        $payment->student_id = $request->student_id;
        $payment->document_type = $request->document_type;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->payment_date = $request->payment_date;

        $payment->save();

        return redirect()->route('treasury.payment.receipt', $payment->id)
                            ->with('success', 'Payment saved successfully.');
    }

    public function showReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        $student = Student::findOrFail($payment->student_id);
        $operator = auth()->user(); 
    
        return view('treasury.payment.receipt', compact('payment', 'student', 'operator'));
    }

    public function getStudentName(Request $request)
    {
        $student = Student::where('id', $request->student_id)->first();

        if ($student) {
            return response()->json(['name' => $student->name], 200);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }
}
    

