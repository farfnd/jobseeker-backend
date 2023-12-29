<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponseTrait;
use App\Models\Experience;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\ExperienceCollection;
use App\Http\Resources\ExperienceResource;
use App\QueryBuilders\ExperienceBuilder;


class ExperienceController extends Controller
{
    use ApiResponseTrait;

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
    public function store(StoreExperienceRequest $request)
    {
        //
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
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
