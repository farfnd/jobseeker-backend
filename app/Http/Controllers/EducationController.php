<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponseTrait;
use App\Models\Education;
use App\Http\Requests\EducationStoreRequest;
use App\Http\Requests\EducationUpdateRequest;
use App\Http\Resources\EducationCollection;
use App\Http\Resources\EducationResource;
use App\QueryBuilders\EducationBuilder;

class EducationController extends Controller
{
    use ApiResponseTrait;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        //
    }
}
