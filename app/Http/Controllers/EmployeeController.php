<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function show($id)
    {
        $employee = Employee::with('user')->findOrFail($id);

        return view('registrar.employee.view', compact('employee'));
    }
}
