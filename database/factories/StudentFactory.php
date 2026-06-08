<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */


class StudentFactory extends Factory
{

    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->userName() . '@gmail.com',
            'address' => fake()->address(),
            'course' => fake()->randomElement(['BSIT', 'BSEMC', 'BSAT', 'BSFT']),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }
}
