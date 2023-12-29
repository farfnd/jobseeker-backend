<?php

namespace App\Console\Commands;

use App\Services\GeoDataFetchService;
use Illuminate\Console\Command;

class FetchProvinces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:provinces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store provinces data from RajaOngkir API';

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
        $provincesCount = $service->fetchProvinces();

        $this->info("Fetched $provincesCount provinces.");
    }
}
