<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Enrollment;
use App\Support\GradeScale;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($validated) {
            $enrollment = Enrollment::lockForUpdate()->findOrFail($validated['enrollment_id']);

            $grade = $enrollment->grade ?: new Grade();
            $grade->fill([
                'grade' => $validated['grade'],
                'status' => GradeScale::statusFor($validated['grade']),
            ])->save();

            $enrollment->update(['grade_id' => $grade->id]);
        });

        return redirect('students')->with('success', 'Student graded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($studentId)
    {
        $grades = Grade::query()
            ->whereHas('enrollment', fn ($query) => $query->where('student_id', $studentId))
            ->with(['enrollment.subject'])
            ->get();

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
        $validated['status'] = GradeScale::statusFor($validated['grade']);

        $grade->update($validated);

        return redirect('students')->with('success', 'Student grade successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        DB::transaction(function () use ($grade) {
            Enrollment::where('grade_id', $grade->id)->update(['grade_id' => null]);
            $grade->delete();
        });

        return redirect('students')->with('success', 'Student grade deleted successfully');
    }
}
