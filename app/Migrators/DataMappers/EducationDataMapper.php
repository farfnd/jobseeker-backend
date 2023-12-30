<?php

namespace App\Migrators\DataMappers;

class EducationDataMapper implements DataMapperInterface
{
    public function map($sqlData)
    {
        return [
            '_id' => $sqlData->id,
            'candidate_id' => $sqlData->candidate_id,
            'institution_name' => $sqlData->institution_name,
            'major' => $sqlData->major,
            'start_year' => $sqlData->start_year,
            'end_year' => $sqlData->end_year,
            'until_now' => $sqlData->until_now,
            'gpa' => $sqlData->gpa,
            'flag' => $sqlData->flag,
            'created_at' => $sqlData->created_at,
            'updated_at' => $sqlData->updated_at,
            'deleted_at' => $sqlData->deleted_at,
        ];
    }
}
