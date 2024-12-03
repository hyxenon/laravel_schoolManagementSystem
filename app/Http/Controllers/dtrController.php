<?php

namespace App\Http\Controllers;
use App\Models\dtr;
use App\Models\Employee;
use Illuminate\Http\Request;

class dtrController extends Controller
{
     // Display all DTRs
     public function index()
     {
         $dtrs = dtr::with('employee.user')->get();  // Eager load the employee's user

         return view('dtr.index', compact('dtrs'));
     }
     // Display a specific DTR
     public function show(dtr $dtr)
     {
         return view('dtr.show', compact('dtr'));
     }
}
