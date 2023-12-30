<?php

namespace App\Migrators\DataMappers;

interface DataMapperInterface
{
    public function map($sqlData);
}
