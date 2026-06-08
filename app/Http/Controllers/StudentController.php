<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->withCount('enrollments')
            ->orderBy('name')
            ->get();

        return view('students.index', ['studentList' => $students]);
    }

    public function create() {}

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        $temporaryPassword = null;

        if ($request->filled('password')) {
            $validated['password'] = $request->string('password')->toString();
        } else {
            $temporaryPassword = Str::password(12);
            $validated['password'] = $temporaryPassword;
        }

        $validated = Arr::except($validated, ['password_confirmation']);

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.')
            ->with('student_temporary_password', $temporaryPassword);
    }

    public function show(Student $student)
    {
        return new StudentResource($student->load(['enrollments.subject', 'enrollments.grade']));
    }

    public function edit(Student $student) {}

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();
        $validated = Arr::except($validated, ['password_confirmation']);

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->back()->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        if (Enrollment::where("student_id", $student->id)->exists()) {
            return redirect('students')->with('error', 'Student is currently enrolled and cannot be deleted!');
        }

        $student->delete();

        return redirect('students')->with('success', 'Student Deleted Successfully');
    }
}
