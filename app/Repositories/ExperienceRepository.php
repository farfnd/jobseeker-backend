<?php

namespace App\Repositories;

use App\Models\Experience;

class ExperienceRepository
{
    public function create(array $data): Experience
    {
        return Experience::create($data);
    }

    public function update(array $data, Experience $experience): Experience
    {
        $experience->update($data);
        return $experience;
    }

    public function getLatestExperienceForUser(int $userId): ?Experience
    {
        return Experience::where('candidate_id', $userId)
            ->orderBy('end_year', 'desc')
            ->first();
    }
}
