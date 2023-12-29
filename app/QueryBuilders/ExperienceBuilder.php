<?php

namespace App\QueryBuilders;

use App\Http\Requests\ExperienceGetRequest;
use App\Models\Experience;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExperienceBuilder extends Builder
{

    public function __construct(ExperienceGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Experience::class, $request)->currentUser();
    }

    protected function getAllowedFields(): array
    {
        return [
            'id',
            'company_name',
            'company_address',
            'position',
            'job_desc',
            'start_year',
            'end_year',
            'until_now',
            'flag',
        ];
    }

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('company_name'),
            AllowedFilter::partial('company_address'),
            AllowedFilter::partial('position'),
            AllowedFilter::partial('job_desc'),
            AllowedFilter::exact('start_year'),
            AllowedFilter::exact('end_year'),
            AllowedFilter::exact('until_now'),
            AllowedFilter::partial('flag'),
        ];
    }

    protected function getAllowedIncludes(): array
    {
        return [
            'candidate',
        ];
    }

    protected function getAllowedSearch(): array
    {
        return [
            'company_name',
            'company_address',
            'position',
            'job_desc',
            'flag',
        ];
    }

    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'company_name',
            'company_address',
            'position',
            'start_year',
            'end_year',
            'until_now',
            'flag',
        ];
    }

    protected function getDefaultSort(): string
    {
        return 'id';
    }
}
