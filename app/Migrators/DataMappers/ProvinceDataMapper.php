<?php

namespace App\Migrators\DataMappers;

class ProvinceDataMapper implements DataMapperInterface
{
    public function map($sqlData)
    {
        return [
            '_id' => $sqlData->id,
            'name' => $sqlData->name,
            'created_at' => $sqlData->created_at,
            'updated_at' => $sqlData->updated_at,
        ];
    }
}
