<?php

namespace App\Services;

use App\Models\Province;
use App\Models\City;
use Illuminate\Support\Facades\Http;

class GeoDataFetchService
{
    public function fetchProvinces()
    {
        $response = Http::get(config('rajaongkir.url') . '/province', [
            'key' => config('rajaongkir.key'),
        ]);

        if ($response->successful()) {
            $provinces = $response->json()['rajaongkir']['results'];

            foreach ($provinces as $provinceData) {
                Province::updateOrCreate([
                    'id' => $provinceData['province_id'],
                ], [
                    'name' => $provinceData['province'],
                ]);
            }

            return count($provinces);
        }

        return 0;
    }

    public function fetchCities()
    {
        $response = Http::get(config('rajaongkir.url') . '/city', [
            'key' => config('rajaongkir.key'),
        ]);

        if ($response->successful()) {
            $cities = $response->json()['rajaongkir']['results'];

            foreach ($cities as $cityData) {
                City::updateOrCreate([
                    'id' => $cityData['city_id'],
                ], [
                    'province_id' => $cityData['province_id'],
                    'name' => $cityData['city_name'],
                    'type' => $cityData['type'],
                    'postal_code' => $cityData['postal_code'],
                ]);
            }

            return count($cities);
        }

        return 0;
    }
}
