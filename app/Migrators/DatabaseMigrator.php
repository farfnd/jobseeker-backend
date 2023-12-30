<?php

namespace App\Migrators;

use App\Migrators\DataMappers\DataMapperInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\Client;

class DatabaseMigrator
{
    public function migrate(DataMapperInterface $dataMapper, string $sqlTable)
    {
        try {
            $sqlData = DB::table($sqlTable)->get();
            $mongoClient = new Client(env('MONGO_DB_URL'));
            $mongoDatabase = env('MONGO_DB_DATABASE');

            $collections = $mongoClient->$mongoDatabase->listCollections(['filter' => ['name' => $sqlTable]]);
            $collectionExists = iterator_count($collections) > 0;

            if (!$collectionExists) {
                Log::info("Creating collection: $sqlTable");
                $mongoClient->$mongoDatabase->createCollection($sqlTable);
            }

            $mongoCollection = $mongoClient->$mongoDatabase->$sqlTable;

            foreach ($sqlData as $data) {
                if ($dataMapper instanceof DataMapperInterface) {
                    $transformedData = $dataMapper->map($data);
                    $this->upsertData($mongoCollection, $transformedData);
                }
            }

            Log::info("Migration successful for table: $sqlTable");
        } catch (\Throwable $e) {
            Log::error("Migration failed for table: $sqlTable. Error: {$e->getMessage()} on line: {$e->getLine()} in file: {$e->getFile()}");
            throw $e;
        }
    }

    private function upsertData(\MongoDB\Collection $collection, array $data)
    {
        $existingData = $collection->findOne(['_id' => $data['_id']]);
        if ($existingData) {
            $collection->replaceOne(['_id' => $data['_id']], $data);
        } else {
            $collection->insertOne($data);
        }
    }
}
