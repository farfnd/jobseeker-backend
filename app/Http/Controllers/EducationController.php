<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponseTrait;
use App\Models\Education;
use App\Http\Requests\EducationStoreRequest;
use App\Http\Requests\EducationUpdateRequest;
use App\Http\Resources\EducationCollection;
use App\Http\Resources\EducationResource;
use App\QueryBuilders\EducationBuilder;
use App\Services\EducationService;

class EducationController extends Controller
{
    use ApiResponseTrait;

    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(EducationBuilder $builder)
    {
        return $this->sendSuccess(
            new EducationCollection($builder->paginate()),
            'Education data retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EducationStoreRequest $request)
    {
        try {
            $newEducationData = $request->validated();
            $education = $this->educationService->create($newEducationData);

            return $this->sendSuccess(
                new EducationResource($education),
                'Education data created successfully.',
                201
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to store education data.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationBuilder $builder, int $educationId)
    {
        return $this->sendSuccess(
            new EducationResource($builder->find($educationId)),
            'Education data retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EducationUpdateRequest $request, Education $education)
    {
        $this->authorize('update', $education);

        try {
            $updateData = $request->validated();
            $education = $this->educationService->update($updateData, $education);

            return $this->sendSuccess(
                new EducationResource($education),
                'Education data updated successfully.',
                200
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to store education data.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $this->authorize('delete', $education);

        try {
            $this->educationService->delete($education);

            return $this->sendSuccess(
                null,
                'Education data deleted successfully.',
                200
            );
        } catch (\Throwable $e) {
            return $this->sendError('Failed to delete education data.', 500);
        }
    }
}
