<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
{
    // Fetch all payrolls
    $payrolls = Payroll::all();  // Or use pagination if necessary

    // Return the view with the payroll data
    return view('payroll.index', compact('payrolls'));
}

    // Create a new payroll record
    public function create()
    {
        $employees = Employee::all();  // Get all employees
        return view('payroll.create', compact('employees'));
    }

    // Store payroll record
    public function store(Request $request)
{
    // Validate the form data
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'amount' => 'required|numeric',
        'payment_date' => 'required|date',
        'status' => 'required|string',
        'remarks' => 'nullable|string',
    ]);

    // Create a new payroll entry
    $payroll = new Payroll();
    $payroll->employee_id = $request->employee_id;
    $payroll->amount = $request->amount;
    $payroll->payment_date = $request->payment_date;
    $payroll->status = $request->status;
    $payroll->remarks = $request->remarks;
    $payroll->save();

    // Redirect back to the payroll list with a success message
    return redirect()->route('payroll.index')->with('success', 'Payroll added successfully.');
}

    // Edit payroll record
    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();  // Get all employees
        return view('payroll.edit', compact('payroll', 'employees'));
    }

    // Update payroll record
    public function update(Request $request, $id)
{
    // Find the payroll by ID
    $payroll = Payroll::findOrFail($id);

    // Validate the incoming data
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'status' => 'required|string',
        'remarks' => 'nullable|string|max:255',
    ]);

    // Update the payroll data
    $payroll->update([
        'amount' => $request->input('amount'),
        'payment_date' => $request->input('payment_date'),
        'status' => $request->input('status'),
        'remarks' => $request->input('remarks'),
    ]);

    // Redirect to the updated payroll page or a list of payrolls
    return redirect()->route('payroll.show', $payroll->id)->with('success', 'Payroll updated successfully');
}

    // Delete payroll record
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payroll.index')->with('success', 'Payroll record deleted successfully.');
    }
}
