<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Enrollment;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::query()
            ->withCount('enrollments')
            ->orderBy('code')
            ->get();

        return view('subjects.index', ['subjectList' => $subjects]);
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
    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();
        Subject::create($validated);

        return redirect('subjects')->with('success', 'Subject added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return new SubjectResource($subject->loadCount('enrollments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validated = $request->validated();
        $subject->update($validated);
        return redirect()->back()->with('success', 'Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if (Enrollment::where("subject_id", $subject->id)->exists()) {
            return redirect('subjects')->with('error', 'There are students currently enrolled to this subject!');
        }
        $subject->delete();
        return redirect('subjects')->with('success', 'Subject Deleted Successfully');
    }
}
