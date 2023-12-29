<?php

namespace App\Services;

use App\Models\Education;
use App\Repositories\EducationRepository;
use Illuminate\Contracts\Auth\Authenticatable;
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

            $education = $this->educationRepository->create($data);
            $this->updateUserLatestEducation($user);

            DB::commit();

            return $education;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, Education $education)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $education = $this->educationRepository->update($data, $education);
            $this->updateUserLatestEducation($user);

            DB::commit();

            return $education;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function updateUserLatestEducation(Authenticatable $user)
    {
        $latestEducation = $this->educationRepository->getLatestEducationForUser($user->id);
        $user->update(['last_educ' => $latestEducation->id]);
    }
}
