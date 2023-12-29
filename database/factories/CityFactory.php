<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $province = Province::inRandomOrder()->first();
        if (!$province) {
            $province = Province::factory()->create();
        }
        return [
            'province_id' => $province->id,
            'name' => $this->faker->city,
            'type' => $this->faker->randomElement(['Kabupaten', 'Kota']),
            'postal_code' => $this->faker->postcode,
        ];
    }
}
