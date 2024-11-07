<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = '4e89cb6596765628fd6138f58d7454e1';
    }

    public function getWeather($city)
    {
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getSoilTemperature($location)
{
    // Get weather data using the location
    $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
        'q' => $location,
        'appid' => $this->apiKey,
        'units' => 'metric',
    ]);

    // Check if the response is successful
    if ($response->successful()) {
        $data = $response->json();

        // Attempt to access soil temperature if available
        if (isset($data['main']['soil_temp'])) {
            return $data['main']['soil_temp']; // Adjust this path according to the actual structure
        } else {
            Log::warning("Soil temperature not found in the response for location: {$location}", $data);
        }
    } else {
        Log::error("Soil temperature API request failed for location: {$location}", [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);
    }

    return null; // Return null if there was an error or no data found
}


}
