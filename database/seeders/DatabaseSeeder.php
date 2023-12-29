<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info("Fetching provinces list");
        Artisan::call('fetch:provinces', array(), $this->command->getOutput());
        $this->command->info("Fetching cities list");
        Artisan::call('fetch:cities', array(), $this->command->getOutput());

        $this->call([
            // ProvinceSeeder::class,
            // CitySeeder::class,

            CandidateSeeder::class,
            EducationSeeder::class,
            ExperienceSeeder::class,
        ]);
    }
}
