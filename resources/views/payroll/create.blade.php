@extends('layouts.app')

@section('content')
    <h1>Create Payroll</h1>
    <form action="{{ route('payroll.store') }}" method="POST">
        @csrf
        <label for="employee_id">Employee:</label>
        <select name="employee_id" id="employee-select" onchange="checkEmploymentType()">
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" data-type="{{ $employee->employment_type }}">{{ $employee->name }}</option>
            @endforeach
        </select>

        <div id="overtime-section" style="display:none;">
            <label for="overtime_hours">Overtime Hours:</label>
            <input type="number" name="overtime_hours" step="0.01">
        </div>

        <label for="bonuses">Bonuses:</label>
        <input type="number" name="bonuses" step="0.01">

        <button type="submit">Create Payroll</button>
    </form>

    <script>
        function checkEmploymentType() {
            var select = document.getElementById('employee-select');
            var selectedOption = select.options[select.selectedIndex];
            var employmentType = selectedOption.getAttribute('data-type');

            var overtimeSection = document.getElementById('overtime-section');
            if (employmentType === 'full-time') {
                overtimeSection.style.display = 'block';
            } else {
                overtimeSection.style.display = 'none';
            }
        }
    </script>
@endsection
