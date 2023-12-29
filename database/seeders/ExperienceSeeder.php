<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();
        foreach ($candidates as $candidate) {
            Experience::factory()->count(3)->create([
                'candidate_id' => $candidate->id,
            ]);

            $latestExperience = Experience::where('candidate_id', $candidate->id)
                ->orderBy('end_year', 'desc')
                ->first();

            if ($latestExperience) {
                $candidate->update(['last_experience' => $latestExperience->id]);
            }
        }
    }
}
