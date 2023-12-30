<?php

namespace App\Migrators\DataMappers;

class CandidateDataMapper implements DataMapperInterface
{
    public function map($sqlData)
    {
        return [
            '_id' => $sqlData->id,
            'full_name' => $sqlData->full_name,
            'dob' => $sqlData->dob,
            'latitude' => $sqlData->latitude,
            'longitude' => $sqlData->longitude,
            'email' => $sqlData->email,
            'email_verified_at' => $sqlData->email_verified_at,
            'password' => $sqlData->password,
            'phone' => $sqlData->phone,
            'gender' => $sqlData->gender,
            'city_id' => $sqlData->city_id,
            'province_id' => $sqlData->province_id,
            'last_educ' => $sqlData->last_educ,
            'last_experience' => $sqlData->last_experience,
            'login_date' => $sqlData->login_date,
            'remember_token' => $sqlData->remember_token,
            'created_at' => $sqlData->created_at,
            'updated_at' => $sqlData->updated_at,
            'deleted_at' => $sqlData->deleted_at,
        ];
    }
}
