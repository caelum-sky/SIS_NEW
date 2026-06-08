<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Subject;
use App\Models\Grade;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}
    public function getSubjects($student_id)
    {
        $enrolledSubjects = Enrollment::where('student_id', $student_id)->pluck('subject_id');
        $subjects = Subject::whereNotIn('id', $enrolledSubjects)->get();
        return response()->json([
            'subjects' => $subjects,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $validated = $request->validated();
        $studentId = $validated['studentId'];
        $subjects = $validated['subjects'];
        foreach ($subjects as $subjectId) {
            $subject = Subject::find($subjectId);
            Enrollment::create([
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'instructor' => 'TBA',
                'tf_units' => $subject?->units ?? 0,
                'lab_units' => 0,
                'schedule' => 'TBA',
                'section' => null,
                'school_year' => '2025-2026',
                'semester' => '1st Semester',
            ]);
        }

        return redirect()->back()->with('success', 'Student enrolled successfully in selected subjects!');
    }

    /**
     * Display the specified resource.
     */
    public function show($student_id)
    {

        $enrollments = Enrollment::with(['student', 'subject', 'grade'])
            ->where('student_id', $student_id)
            ->get();

        return response()->json($enrollments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, $id)
    {
        $validated = $request->validated();
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update([
            'instructor' => $validated['instructor']
        ]);
        return redirect()->back()->with('success', 'Student enrollment successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();
        return redirect('students')->with('success', 'Subject has been successfully removed!');
    }
}
