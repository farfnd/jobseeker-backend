<?php

namespace App\Repositories;

use App\Models\Experience;

class ExperienceRepository
{
    public function create(array $data): Experience
    {
        return Experience::create($data);
    }

    public function getLatestExperienceForUser(int $userId): ?Experience
    {
        return Experience::where('candidate_id', $userId)
            ->orderBy('end_year', 'desc')
            ->first();
    }
}
