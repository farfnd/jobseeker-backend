<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'dob' => $this->faker->date,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'phone' => $this->faker->phoneNumber,
            'password' => static::$password ??= Hash::make('password'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'city_id' => $this->faker->numberBetween(1, 10),
            'province_id' => $this->faker->numberBetween(1, 5),
            'last_educ' => $this->faker->sentence,
            'last_experience' => $this->faker->sentence,
            'login_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
