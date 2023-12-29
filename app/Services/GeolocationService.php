<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeolocationService
{
    protected $url = "http://ip-api.com/json";

    public function getLatitudeFromIP($ip)
    {
        $response = Http::get("$this->url/$ip");

        if ($response->successful()) {
            $geolocationData = $response->json();
            return $geolocationData['lat'] ?? null;
        }
        return null;
    }

    public function getLongitudeFromIP($ip)
    {
        $response = Http::get("$this->url/$ip");

        if ($response->successful()) {
            $geolocationData = $response->json();
            return $geolocationData['lon'] ?? null;
        }
        return null;
    }
}
