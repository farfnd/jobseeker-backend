<?php

namespace App\Migrators\DataMappers;

class ExperienceDataMapper implements DataMapperInterface
{
    public function map($sqlData)
    {
        return [
            '_id' => $sqlData->id,
            'candidate_id' => $sqlData->candidate_id,
            'company_name' => $sqlData->company_name,
            'company_address' => $sqlData->company_address,
            'position' => $sqlData->position,
            'job_desc' => $sqlData->job_desc,
            'start_year' => $sqlData->start_year,
            'end_year' => $sqlData->end_year,
            'until_now' => $sqlData->until_now,
            'flag' => $sqlData->flag,
            'created_at' => $sqlData->created_at,
            'updated_at' => $sqlData->updated_at,
            'deleted_at' => $sqlData->deleted_at,
        ];
    }
}
