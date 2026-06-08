<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_number' => $this->student_number,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'course' => $this->course,
            'year_level' => $this->year_level,
            'section' => $this->section,
            'enrollment_status' => $this->enrollment_status,
            'enrollments' => $this->whenLoaded('enrollments'),
        ];
    }
}
