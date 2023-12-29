<?php

namespace App\Repositories;

use App\Models\Education;
use Illuminate\Support\Collection;

class EducationRepository
{
    public function create(array $data): Education
    {
        return Education::create($data);
    }

    public function update(array $data, Education $education): Education
    {
        $education->update($data);
        return $education;
    }

    public function getLatestEducationForUser(int $userId): ?Education
    {
        return Education::where('candidate_id', $userId)
            ->orderBy('end_year', 'desc')
            ->first();
    }
}
