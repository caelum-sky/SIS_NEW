<?php

namespace Database\Factories;

use App\Support\GradeScale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grade = $this->faker->randomElement(GradeScale::values());

        return [
            'grade' => $grade,
            'status' => GradeScale::statusFor($grade),
        ];
    }
}
