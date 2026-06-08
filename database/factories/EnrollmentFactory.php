<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'instructor' => $this->faker->name(),
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory(),
            'subject_id' => Subject::inRandomOrder()->first()->id ?? Subject::factory(),
        ];
    }
}
