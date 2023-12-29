<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();
        foreach ($candidates as $candidate) {
            Education::factory()->count(3)->create([
                'candidate_id' => $candidate->id,
            ]);

            $latestEducation = Education::where('candidate_id', $candidate->id)
                ->orderBy('end_year', 'desc')
                ->first();

            if ($latestEducation) {
                $candidate->update(['last_educ' => $latestEducation->id]);
            }
        }
    }
}
