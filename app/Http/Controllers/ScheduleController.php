<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Employee;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {

        $schedules = Schedule::with(['subject', 'room', 'teacher'])->get();

        return view('program_head.schedules.index', compact('schedules'));
    }

    public function create()
    {

        $programHead = Auth::user()->employee;
        if (!$programHead || !$programHead->departmentsLed->count()) {
            abort(403, 'You do not have permission to create a schedule.');
        }

        $department = $programHead->departmentsLed->first();


        $subjects = Subject::whereHas('course', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })->get();


        $teachers = Employee::where('position', 'teacher')->get();
        $rooms = Room::all();

        return view('program_head.schedules.create', compact('subjects', 'rooms', 'teachers'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'required|exists:rooms,id',
            'employee_id' => 'required|exists:employees,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'block' => 'required|integer|max:255',
            'year' => 'required|integer|min:1|max:6',
        ]);


        $conflict = Schedule::where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->where('room_id', $request->room_id)
                    ->orWhere('employee_id', $request->employee_id);
            })
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->end_time);
                    });
            })
            ->where('start_time', '!=', $request->end_time)
            ->where('end_time', '!=', $request->start_time)
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['conflict' => 'The schedule conflicts with an existing schedule.'])->withInput();
        }


        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);


        $programHead = Auth::user()->employee;
        $department = $programHead->departmentsLed->first();
        $subjects = Subject::whereHas('course', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })->get();

        $teachers = Employee::where('position', 'teacher')->get();
        $rooms = Room::all();

        return view('program_head.schedules.edit', compact('schedule', 'subjects', 'teachers', 'rooms'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'required|exists:rooms,id',
            'employee_id' => 'required|exists:employees,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'block' => 'required|integer|max:255',
            'year' => 'required|integer|min:1|max:6',
        ]);


        $conflict = Schedule::where('day_of_week', $request->day_of_week)
            ->where('id', '!=', $id) // Exclude the current schedule from the conflict check
            ->where(function ($query) use ($request) {
                $query->where('room_id', $request->room_id)
                    ->orWhere('employee_id', $request->employee_id);
            })
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->end_time);
                    });
            })
            ->where('start_time', '!=', $request->end_time)
            ->where('end_time', '!=', $request->start_time)
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['conflict' => 'The schedule conflicts with an existing schedule.'])->withInput();
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
