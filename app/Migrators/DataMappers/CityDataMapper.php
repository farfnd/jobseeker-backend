<?php

namespace App\Migrators\DataMappers;

class CityDataMapper implements DataMapperInterface
{
    public function map($sqlData)
    {
        return [
            '_id' => $sqlData->id,
            'province_id' => $sqlData->province_id,
            'type' => $sqlData->type,
            'name' => $sqlData->name,
            'postal_code' => $sqlData->postal_code,
            'created_at' => $sqlData->created_at,
            'updated_at' => $sqlData->updated_at,
        ];
    }
}
