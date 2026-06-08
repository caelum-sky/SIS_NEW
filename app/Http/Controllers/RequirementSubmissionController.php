<?php

namespace App\Http\Controllers;

use App\Models\RequirementSubmission;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RequirementSubmissionController extends Controller
{
    public function studentIndex()
    {
        $student = auth('student')->user();
        $enrollmentYear = request('enrollment_year', now()->year . '-' . (now()->year + 1));
        $enrollmentType = request('enrollment_type', $student->year_level === '1' ? 'first_time' : 'continuing');

        $submissions = RequirementSubmission::query()
            ->where('student_id', $student->id)
            ->where('enrollment_year', $enrollmentYear)
            ->get()
            ->keyBy('requirement_key');

        return view('requirements.student', [
            'student' => $student,
            'requirements' => RequirementSubmission::REQUIREMENTS,
            'submissions' => $submissions,
            'enrollmentYear' => $enrollmentYear,
            'enrollmentType' => $enrollmentType,
        ]);
    }

    public function store(Request $request)
    {
        $student = auth('student')->user();

        $validated = $request->validate([
            'requirement_key' => ['required', Rule::in(array_keys(RequirementSubmission::REQUIREMENTS))],
            'enrollment_year' => ['required', 'string', 'max:20'],
            'enrollment_type' => ['required', Rule::in(['first_time', 'continuing'])],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $requirement = RequirementSubmission::REQUIREMENTS[$validated['requirement_key']];
        $path = $request->file('document')->store("requirements/{$student->id}", 'public');

        RequirementSubmission::updateOrCreate(
            [
                'student_id' => $student->id,
                'enrollment_year' => $validated['enrollment_year'],
                'requirement_key' => $validated['requirement_key'],
            ],
            [
                'enrollment_type' => $validated['enrollment_type'],
                'title' => $requirement['title'],
                'description' => $requirement['description'],
                'file_path' => $path,
                'status' => 'submitted',
                'submitted_at' => now(),
                'remarks' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]
        );

        return redirect()
            ->route('student.requirements.index', [
                'enrollment_year' => $validated['enrollment_year'],
                'enrollment_type' => $validated['enrollment_type'],
            ])
            ->with('success', $requirement['title'] . ' submitted successfully.');
    }

    public function adminIndex()
    {
        $submissions = RequirementSubmission::with(['student:id,name,email,course', 'reviewer:id,name'])
            ->latest('submitted_at')
            ->paginate(20);

        return view('requirements.admin', compact('submissions'));
    }

    public function review(Request $request, RequirementSubmission $requirement)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected', 'needs_revision'])],
            'remarks' => ['nullable', 'string'],
        ]);

        $requirement->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requirement review saved.');
    }
}
