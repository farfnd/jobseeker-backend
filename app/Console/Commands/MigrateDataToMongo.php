<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MigrateDataToMongo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-data-to-mongo {table? : The table to migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from SQL database to MongoDB';

    /**
     * The database migrator.
     *
     * @var \App\Migrators\DatabaseMigrator
     */
    protected $databaseMigrator;

    /**
     * The tables to migrate.
     *
     * @var array
     */
    protected $tables = [
        'provinces' => 'App\Migrators\DataMappers\ProvinceDataMapper',
        'cities' => 'App\Migrators\DataMappers\CityDataMapper',
        'candidates' => 'App\Migrators\DataMappers\CandidateDataMapper',
        'education' => 'App\Migrators\DataMappers\EducationDataMapper',
        'experiences' => 'App\Migrators\DataMappers\ExperienceDataMapper',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->databaseMigrator = app('App\Migrators\DatabaseMigrator');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tableArgument = $this->argument('table');

        if ($tableArgument) {
            if (!array_key_exists($tableArgument, $this->tables)) {
                $this->error("Invalid table specified: $tableArgument");
                return;
            }

            $this->migrateTable($this->tables[$tableArgument], $tableArgument);
        } else {
            $this->migrateAllTables();
        }
    }

    /**
     * Migrate data from a single table.
     *
     * @param $dataMapper
     * @param $table
     */
    protected function migrateTable($dataMapper, $table)
    {
        try {
            $this->info("Migrating data from table $table...");
            $this->databaseMigrator->migrate(app($dataMapper), $table);
            $this->info("Data from table $table migrated successfully!");
        } catch (\Exception $e) {
            $this->error("Error migrating data from table $table: " . $e->getMessage());
            Log::error("Error migrating data from table $table: " . $e->getMessage());
        }
    }

    /**
     * Migrate data from all tables.
     */
    protected function migrateAllTables()
    {
        $this->info('Migrating data to MongoDB for all tables...');

        foreach ($this->tables as $table => $dataMapper) {
            $this->migrateTable($dataMapper, $table);
        }
    }
}
