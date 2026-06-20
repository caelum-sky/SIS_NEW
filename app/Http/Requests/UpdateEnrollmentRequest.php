<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
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
            'instructor' => ['required', 'string', 'max:255'],
            'tf_units' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'lab_units' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:50'],
            'room' => ['nullable', 'string', 'max:50'],
            'school_year' => ['nullable', 'string', 'max:20'],
            'semester' => ['nullable', 'string', 'max:50'],
        ];
    }
}
