<?php

namespace App\QueryBuilders;

use App\Http\Requests\EducationGetRequest;
use App\Models\Education;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EducationBuilder extends Builder
{

    public function __construct(EducationGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Education::class, $request)->currentUser();
    }

    protected function getAllowedFields(): array
    {
        return [
            'id',
            'candidate_id',
            'institution_name',
            'major',
            'start_year',
            'end_year',
            'until_now',
            'gpa',
            'flag',
        ];
    }

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('institution_name'),
            AllowedFilter::partial('major'),
            AllowedFilter::exact('start_year'),
            AllowedFilter::exact('end_year'),
            AllowedFilter::exact('until_now'),
            AllowedFilter::exact('gpa'),
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
            'institution_name',
            'major',
            'flag',
        ];
    }

    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'candidate_id',
            'institution_name',
            'major',
            'start_year',
            'end_year',
            'until_now',
            'gpa',
        ];
    }

    protected function getDefaultSort(): string
    {
        return 'id';
    }
}
