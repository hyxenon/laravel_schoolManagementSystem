<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function create()
    {
        // Pass employee data to the view to populate the employee select input
        $employees = Employee::all();
        return view('payroll.create', compact('employees'));
    }

    // Store the newly created payroll in the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        // Create a new payroll record
        Payroll::create([
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        // Redirect to the payroll list with a success message
        return redirect()->route('payroll.index')->with('success', 'Payroll added successfully.');
    }

    // Show the payroll list
    public function index()
    {
        $payrolls = Payroll::with('employees')->get();
        return view('payroll.index', compact('payrolls'));
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
    public function show($id)
    {
        // Find payroll by ID
        $payroll = Payroll::findOrFail($id);

        // Return view with the payroll data
        return view('payroll.show', compact('payroll'));
    }
}
