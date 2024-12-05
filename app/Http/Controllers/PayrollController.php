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
        // Eager load the 'user' relationship to get the employee names
        $employees = Employee::with('user')->get();

        // Pass the employees to the view
        return view('payroll.create', compact('employees'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',  // Ensure the employee exists
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        // Create the new Payroll record
        Payroll::create([
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        // Redirect with success message
        return redirect()->route('payroll.index')->with('success', 'Payroll added successfully!');
    }
    public function index()
    {
        // Fetch payrolls and their associated employees
        $payrolls = Payroll::with('employee.user')->get();  // Eager load the employee's user

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
