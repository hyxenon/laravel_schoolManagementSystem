<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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
            //'exam_type' => 'nullable|string',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            //'security_code' => 'required|string',
        ]);

        // payment record
        $payment = new Payment();
        $payment->student_id = $request->student_id;
        $payment->document_type = $request->document_type;
        //$payment->exam_type = $request->exam_type;
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
        return view('treasury.payment.receipt', compact('payment'));
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        $operator = auth()->user(); 
    
        return view('treasury.payment.receipt', compact('payment', 'operator'));
    }

}
    