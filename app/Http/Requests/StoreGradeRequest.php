<?php

namespace App\Http\Requests;

use App\Support\GradeScale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGradeRequest extends FormRequest
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
            'grade' => [
                'required',
                Rule::in(GradeScale::values()),
            ],
            'enrollment_id' => 'required|exists:enrollments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'grade.in' => 'The grade must be a valid grade from 1.00 to 5.00, INC, or FDA.',
        ];
    }
}
