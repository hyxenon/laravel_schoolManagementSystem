<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Contract;
use App\Models\WorkHours;
class PayrollController extends Controller
{
    public function store(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $bonuses = $request->bonuses;
        $grossIncome = 0;

        // Full-time Employee Salary Calculation
        if ($employee->employment_type == 'full-time') {
            $overtimeHours = $request->overtime_hours;
            $grossIncome = $employee->base_salary + ($overtimeHours * $employee->hourly_rate) + $bonuses;
        }
        // Part-time Employee Salary Calculation
        else {
            $workHours = WorkHours::where('employee_id', $employee->id)->sum('hours');
            $grossIncome = $workHours * $employee->hourly_rate + $bonuses;
        }

        // Fetch contract details for salary adjustments
        $activeContract = Contract::where('employee_id', $employee->id)->orderBy('effective_date', 'desc')->first();
        $taxDeductions = $this->calculateTaxes($grossIncome);
        $insuranceDeductions = $this->calculateInsurance($activeContract->base_salary);
        $leaveDeductions = $this->calculateLeaveDeductions($employee->id);

        $netSalary = $grossIncome - $taxDeductions - $insuranceDeductions - $leaveDeductions;

        Payroll::create([
            'employee_id' => $employee->id,
            'base_salary' => $activeContract->base_salary,
            'overtime_hours' => $overtimeHours ?? 0,
            'bonuses' => $bonuses,
            'tax_deductions' => $taxDeductions,
            'insurance_deductions' => $insuranceDeductions,
            'leave_deductions' => $leaveDeductions,
            'net_salary' => $netSalary
        ]);

        return redirect()->route('payroll.index');
    }

    protected function calculateTaxes($grossIncome)
    {
        return $grossIncome * 0.15; // Example tax rate
    }

    protected function calculateInsurance($baseSalary)
    {
        return $baseSalary * 0.05; // Example insurance deduction rate
    }

    protected function calculateLeaveDeductions($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee->employment_type == 'full-time') {
            return $employee->unpaid_leave_days * ($employee->base_salary / 30);
        } else {
            return ($employee->paid_leave_days + $employee->unpaid_leave_days) * ($employee->base_salary / 30);
        }
    }
}
