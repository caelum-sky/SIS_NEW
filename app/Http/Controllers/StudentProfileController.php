<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentPasswordUpdateRequest;
use App\Http\Requests\StudentProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    public function edit(): View
    {
        return view('studentsViews.profile', [
            'student' => auth('student')->user(),
        ]);
    }

    public function update(StudentProfileUpdateRequest $request): RedirectResponse
    {
        $student = auth('student')->user();
        $student->update($request->validated());

        return redirect()
            ->route('student.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(StudentPasswordUpdateRequest $request): RedirectResponse
    {
        auth('student')->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return redirect()
            ->route('student.profile.edit')
            ->with('password_success', 'Password updated successfully.');
    }
}
