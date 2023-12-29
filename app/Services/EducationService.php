<?php

namespace App\Services;

use App\Repositories\EducationRepository;
use Illuminate\Support\Facades\DB;

class EducationService
{
    protected $educationRepository;

    public function __construct(EducationRepository $educationRepository)
    {
        $this->educationRepository = $educationRepository;
    }

    public function create(array $data)
    {
        $user = auth()->user();
        $data = array_merge($data, [
            'candidate_id' => $user->id,
        ]);

        try {
            DB::beginTransaction();

            $education = $this->educationRepository->createEducation($data);
            $latestEducation = $this->educationRepository->getLatestEducationForUser($user->id);
            $user->update(['last_educ' => $latestEducation->id]);

            DB::commit();

            return $education;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
