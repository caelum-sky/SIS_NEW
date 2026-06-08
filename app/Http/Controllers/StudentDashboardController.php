<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth('student')->user();

        if (!$student) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['subject', 'grade'])
            ->get();
        return view('studentsViews.index', compact('enrollments'));
    }
}
