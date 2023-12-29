<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $candidate = Candidate::inRandomOrder()->first();
        if (!$candidate) {
            $candidate = Candidate::factory()->create();
        }

        return [
            'candidate_id' => $candidate->id,
            'institution_name' => $this->faker->company,
            'major' => $this->faker->jobTitle,
            'start_year' => $this->faker->year,
            'end_year' => $this->faker->year,
            'until_now' => $this->faker->boolean,
            'gpa' => $this->faker->randomFloat(2, 1, 4),
            'flag' => $this->faker->randomElement(['flag1', 'flag2', 'flag3']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
