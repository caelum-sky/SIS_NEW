<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;


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
        $schoolYear = $validated['school_year'] ?? '2025-2026';
        $semester = $validated['semester'] ?? '1st Semester';
        $section = $validated['section'] ?? null;

        DB::transaction(function () use ($studentId, $subjects, $schoolYear, $semester, $section) {
            $subjectModels = Subject::whereIn('id', $subjects)->get()->keyBy('id');

            foreach ($subjects as $subjectId) {
                $subject = $subjectModels->get($subjectId);

                Enrollment::create([
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'instructor' => 'TBA',
                    'tf_units' => $subject?->units ?? 0,
                    'lab_units' => 0,
                    'schedule' => 'TBA',
                    'section' => $section,
                    'school_year' => $schoolYear,
                    'semester' => $semester,
                ]);
            }
        });

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
        $enrollment->update(array_filter([
            'instructor' => $validated['instructor'],
            'tf_units' => $validated['tf_units'] ?? null,
            'lab_units' => $validated['lab_units'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'section' => $validated['section'] ?? null,
            'room' => $validated['room'] ?? null,
            'school_year' => $validated['school_year'] ?? null,
            'semester' => $validated['semester'] ?? null,
        ], fn ($value) => $value !== null));

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
