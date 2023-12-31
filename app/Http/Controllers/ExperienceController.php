<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponseTrait;
use App\Models\Experience;
use App\Http\Requests\ExperienceStoreRequest;
use App\Http\Requests\ExperienceUpdateRequest;
use App\Http\Resources\ExperienceCollection;
use App\Http\Resources\ExperienceResource;
use App\QueryBuilders\ExperienceBuilder;
use App\Services\ExperienceService;

class ExperienceController extends Controller
{
    use ApiResponseTrait;

    protected $experienceService;

    public function __construct(ExperienceService $experienceService)
    {
        $this->experienceService = $experienceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ExperienceBuilder $builder)
    {
        return $this->sendSuccess(
            new ExperienceCollection($builder->paginate()),
            'Experience data retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExperienceStoreRequest $request)
    {
        try {
            $newExperienceData = $request->validated();
            $experience = $this->experienceService->create($newExperienceData);

            return $this->sendSuccess(
                new ExperienceResource($experience),
                'Experience data created successfully.',
                201
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to store experience data.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExperienceBuilder $builder, int $experienceId)
    {
        return $this->sendSuccess(
            new ExperienceResource($builder->find($experienceId)),
            'Experience data retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExperienceUpdateRequest $request, Experience $experience)
    {
        $this->authorize('update', $experience);

        try {
            $updateData = $request->validated();
            $experience = $this->experienceService->update($updateData, $experience);

            return $this->sendSuccess(
                new ExperienceResource($experience),
                'Experience data updated successfully.',
                200
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to store experience data.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience);

        try {
            $this->experienceService->delete($experience);

            return $this->sendSuccess(
                null,
                'Experience data deleted successfully.',
                200
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to delete experience data.', 500);
        }
    }
}
