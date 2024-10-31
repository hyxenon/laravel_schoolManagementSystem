<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function showSubject()
    {
        // Get the currently logged-in user
        $userId = Auth::id();

        // Find the employee associated with the logged-in user
        $employee = User::find($userId)->employee; 

        if (!$employee) {
            return view('professor.grade.g-subject')->with('subjects', collect()); // Return empty if no employee found
        }

        // Fetch the schedules for the found employee
        $schedules = Schedule::with('subject')->where('employee_id', $employee->id)->get();

        // Extract subjects from the schedules
        $subjects = $schedules->pluck('subject')->unique('id');

        return view('professor.grade.g-subject', compact('subjects'));
    }
    
    public function showStudents($subjectId)
    {
        // Retrieve the schedule based on the subject ID, including students
        $schedule = Schedule::with('students')->where('subject_id', $subjectId)->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        // Get students associated with this schedule
        $students = $schedule->students;

        return view('professor.grade.g-student', compact('students', 'schedule'));
    }

    /*public function showStudentGrades($studentId, $subjectId)
    {
        // Retrieve the schedule based on the subject ID
        $schedule = Schedule::with(['subject.assignments.submissions'])
            ->where('subject_id', $subjectId)
            ->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        // Get the student based on the student ID
        $student = Student::find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // Get assignments and their corresponding submissions for this student
        $assignments = $schedule->subject->assignments;

        return view('professor.grade.grade', compact('student', 'assignments', 'schedule'));
    }


    public function showStudentGrades($studentId, $subjectId)
    {
        // Retrieve the schedule and assignments
        $schedule = Schedule::with(['subject.assignments.submissions'])
            ->where('subject_id', $subjectId)
            ->first();
    
        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }
    
        // Get the student based on the student ID
        $student = Student::find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
    
        // Group submissions by type (you can adjust this logic based on your needs)
        $assignments = $schedule->subject->assignments;
        $gradesByType = [];
    
        foreach ($assignments as $assignment) {
            foreach ($assignment->submissions as $submission) {
                if ($submission->student_id === $student->id) {
                    $gradesByType[$assignment->type][] = [
                        'title' => $assignment->title,
                        'grade' => $submission->grade,
                    ];
                }
            }
        }
    
        return view('professor.grade.grade', compact('student', 'gradesByType', 'schedule'));
    }*/
    
    public function showStudentGrades($subjectId, $studentId)
    {
        // Retrieve the schedule based on the subject ID
        $schedule = Schedule::with(['subject.assignments.submissions'])
            ->where('subject_id', $subjectId)
            ->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        // Get the student based on the student ID
        $student = Student::with('user')->find($studentId); // Ensure the user relationship is loaded
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // Fetch grades for prelim, midterm, and final
        $prelimGrades = Grade::where('student_id', $studentId)
                            ->where('subject_id', $subjectId)
                            ->where('term', 'prelim')
                            ->with('assignment') // Ensure assignment is loaded
                            ->get();

        $midtermGrades = Grade::where('student_id', $studentId)
                            ->where('subject_id', $subjectId)
                            ->where('term', 'midterm')
                            ->with('assignment') // Ensure assignment is loaded
                            ->get();

        $finalGrades = Grade::where('student_id', $studentId)
                            ->where('subject_id', $subjectId)
                            ->where('term', 'final')
                            ->with('assignment') // Ensure assignment is loaded
                            ->get();

        // Pass the student and grades to the view
        return view('professor.grade.grade', compact('student', 'prelimGrades', 'midtermGrades', 'finalGrades'));
    }


    public function storeGrade(Request $request) {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_value' => 'required|numeric',
            'term' => 'required|string',
        ]);
    
        Grade::create($request->all());
        
        return redirect()->back()->with('success', 'Grade recorded successfully!');
    }



    


    private function calculateSemesterGrade($studentId, $subjectId)
    {
        // Fetch all grades for the semester
        $grades = Grade::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->get();

        // Calculate the average grade
        $average = $grades->avg('grade_value');

        return round($average, 2); // Round to 2 decimal places
    }
}
