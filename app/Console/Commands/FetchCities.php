<?php

namespace App\Console\Commands;

use App\Services\GeoDataFetchService;
use Illuminate\Console\Command;

class FetchCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store cities data from RajaOngkir API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(GeoDataFetchService $service)
    {
        $citiesCount = $service->fetchCities();

        $this->info("Fetched $citiesCount cities.");
    }
}
