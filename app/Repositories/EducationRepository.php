<?php

namespace App\Repositories;

use App\Models\Education;
use Illuminate\Support\Collection;

class EducationRepository
{
    public function createEducation(array $data): Education
    {
        return Education::create($data);
    }

    public function getLatestEducationForUser(int $userId): ?Education
    {
        return Education::where('candidate_id', $userId)
            ->orderBy('end_year', 'desc')
            ->first();
    }
}
