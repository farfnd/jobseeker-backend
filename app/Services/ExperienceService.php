<?php

namespace App\Services;

use App\Models\Experience;
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

    public function update(array $data, Experience $experience)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $experience = $this->experienceRepository->update($data, $experience);
            $this->updateUserLatestExperience($user);

            DB::commit();

            return $experience;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Experience $experience)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $experience->delete();
            $this->updateUserLatestExperience($user);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function updateUserLatestExperience(Authenticatable $user)
    {
        $latestExperience = $this->experienceRepository->getLatestExperienceForUser($user->id);
        $user->update(['last_experience' => $latestExperience ? $latestExperience->id : null]);
    }
}
