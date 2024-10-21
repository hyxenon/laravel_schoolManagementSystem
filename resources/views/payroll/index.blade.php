@extends('layouts.app')

@section('content')
    <h1>Payroll List</h1>
    <table>
        <tr>
            <th>Employee</th>
            <th>Basic Salary</th>
            <th>Overtime Hours</th>
            <th>Bonuses</th>
            <th>Tax Deductions</th>
            <th>Insurance Deductions</th>
            <th>Leave Deductions</th>
            <th>Net Salary</th>
        </tr>
        @foreach($payrolls as $payroll)
        <tr>
            <td>{{ $payroll->employee->name }}</td>
            <td>{{ $payroll->base_salary }}</td>
            <td>{{ $payroll->overtime_hours }}</td>
            <td>{{ $payroll->bonuses }}</td>
            <td>{{ $payroll->tax_deductions }}</td>
            <td>{{ $payroll->insurance_deductions }}</td>
            <td>{{ $payroll->leave_deductions }}</td>
            <td>{{ $payroll->net_salary }}</td>
        </tr>
        @endforeach
    </table>
@endsection
