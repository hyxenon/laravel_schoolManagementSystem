<?php

namespace Database\Seeders;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollSeeder extends Seeder
{
    public function run()
    {
        Payroll::create([
            'employee_id' => 1,  // Assuming you have an employee with ID 1
            'amount' => 1000.50,
            'payment_date' => Carbon::now(),
            'status' => 'Paid',
            'remarks' => 'Salary for September',
        ]);

        Payroll::create([
            'employee_id' => 2,  // Assuming you have an employee with ID 2
            'amount' => 1200.75,
            'payment_date' => Carbon::now(),
            'status' => 'Pending',
            'remarks' => 'Salary for October',
        ]);
    }
}
