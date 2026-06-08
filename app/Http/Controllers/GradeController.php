<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Enrollment;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $validated = $request->validated();

        // Corrected status logic
        if ($validated['grade'] === 'INC') {
            $status = 'Incomplete';
        } elseif ($validated['grade'] === 'FDA'){
            $status = 'Failure Due to Absences';
        } elseif ($validated['grade'] > 3) {
            $status = 'Failed';
        } elseif ($validated['grade'] >= 1 && $validated['grade'] <= 3) {
            $status = 'Passed';
        }

        // Create grade entry
        $grade = Grade::create([
            'grade' => $validated['grade'],
            'status' => $status,
        ]);

        // Update enrollment with grade_id
        Enrollment::where('id', $validated['enrollment_id'])
            ->update(['grade_id' => $grade->id]);

        return redirect('students')->with('success', 'Student graded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($studentId)
    {
        $grades = Grade::where('student_id', $studentId)->with('subject')->get();

        return response()->json($grades);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $validated = $request->validated();

        // Corrected status logic
        if ($validated['grade'] === 'INC') {
            $validated['status'] = 'Incomplete';
        } elseif ($validated['grade'] === 'FDA') {
            $validated['status'] = 'Failure Due to Absences';
        } elseif ($validated['grade'] > 3) {
            $validated['status'] = 'Failed';
        } elseif ($validated['grade'] >= 1 && $validated['grade'] <= 3) {
            $validated['status'] = 'Passed';
        }

        $grade->update($validated);

        return redirect('students')->with('success', 'Student grade successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        Enrollment::where('grade_id', $grade->id)->update(['grade_id' => null]);
        $grade->delete();

        return redirect('students')->with('success', 'Student grade deleted successfully');
    }
}
