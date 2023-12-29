<?php

namespace App\Services;

use App\Repositories\ExperienceRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class ExperienceService
{
    protected $experienceRepository;

    public function __construct(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
    }

    public function create(array $data)
    {
        $user = auth()->user();
        $data = array_merge($data, [
            'candidate_id' => $user->id,
        ]);

        try {
            DB::beginTransaction();

            $experience = $this->experienceRepository->create($data);
            $this->updateUserLatestExperience($user);

            DB::commit();

            return $experience;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function updateUserLatestExperience(Authenticatable $user)
    {
        $latestExperience = $this->experienceRepository->getLatestExperienceForUser($user->id);
        $user->update(['last_educ' => $latestExperience->id]);
    }
}
