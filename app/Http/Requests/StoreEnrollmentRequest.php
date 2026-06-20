<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $schoolYear = $this->input('school_year', '2025-2026');
        $semester = $this->input('semester', '1st Semester');

        return [
            'studentId' => ['required', 'exists:students,id'],
            'subjects' => ['required', 'array'],
            'school_year' => ['nullable', 'string', 'max:20'],
            'semester' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'subjects.*' => [
                'distinct',
                'exists:subjects,id',
                function ($attribute, $value, $fail) use ($schoolYear, $semester) {
                    $studentId = $this->input('studentId');
                    $alreadyEnrolled = Enrollment::where('student_id', $studentId)
                        ->where('subject_id', $value)
                        ->where('school_year', $schoolYear)
                        ->where('semester', $semester)
                        ->exists();

                    if ($alreadyEnrolled) {
                        $fail('The student is already enrolled in this subject for the selected school year and semester.');
                    }
                }
            ],
        ];
    }
}
