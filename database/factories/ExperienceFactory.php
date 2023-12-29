<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $candidate = \App\Models\Candidate::inRandomOrder()->first();
        if (!$candidate) {
            $candidate = \App\Models\Candidate::factory()->create();
        }

        return [
            'candidate_id' => $candidate->id,
            'company_name' => $this->faker->company,
            'company_address' => $this->faker->address,
            'position' => $this->faker->jobTitle,
            'job_desc' => $this->faker->paragraph,
            'start_year' => $this->faker->year,
            'end_year' => $this->faker->year,
            'until_now' => $this->faker->boolean,
            'flag' => $this->faker->randomElement(['flag1', 'flag2', 'flag3']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
