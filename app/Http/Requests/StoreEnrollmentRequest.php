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
        return [
            'studentId' => ['required', 'exists:students,id'],
            'subjects' => ['required', 'array'],
            'subjects.*' => [
                'distinct',
                'exists:subjects,id',
                function ($attribute, $value, $fail) {
                    $studentId = $this->input('studentId');
                    $alreadyEnrolled = Enrollment::where('student_id', $studentId)
                        ->where('subject_id', $value)
                        ->exists();

                    if ($alreadyEnrolled) {
                        $fail("The student is already enrolled in this subject.");
                    }
                }
            ],
        ];
    }
}
