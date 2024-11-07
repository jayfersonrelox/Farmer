<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Models\Farmer; // Import the Farmer model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
{
    $farmers = Farmer::all();
    $weatherData = [];

    foreach ($farmers as $farmer) {
        // Get weather data for each farmer's location
        $weather = $this->weatherService->getWeather($farmer->location);

        if ($weather) {
            $soilTemperature = $this->weatherService->getSoilTemperature($farmer->location);

            $weatherData[] = [
                'name' => $farmer->name,
                'location' => $farmer->location,
                'temp' => $weather['main']['temp'] ?? null,
                'description' => $weather['weather'][0]['description'] ?? 'N/A',
                'soil_temp' => $soilTemperature ?? 'N/A',
            ];
        }
    }

    return view('weather.show', ['weatherData' => $weatherData]);
}
public function getSoilTemperature(Request $request)
{
    $location = $request->input('location');
    $api_key = '4e724953fbebdff3ddb7cb8e69dv6700dacd5bfa27355e20017bafd05bdc218b';

    // Call the API to get the soil temperature
    $response = Http::get('https://api.example.com/soil-temperature', [
        'location' => $location,
        'api_key' => $api_key
    ]);

    // Handle the response
    if ($response->successful()) {
        $data = $response->json();
        return response()->json(['temperature' => $data['temperature']]); // Adjust according to your actual response
    } else {
        return response()->json(['error' => 'Unable to fetch temperature'], 500);
    }
}

public function getWeather($cropId)
{
    // Find the farmer by crop ID (assuming each crop belongs to a farmer)
    $farmer = Farmer::find($cropId);

    if (!$farmer) {
        return response()->json(['error' => 'Farmer not found'], 404);
    }

    // Get weather data for the farmer's location
    $weather = $this->weatherService->getWeather($farmer->location);

    if ($weather) {
        $soilTemperature = $this->weatherService->getSoilTemperature($farmer->location);

        return response()->json([
            'name' => $farmer->name,
            'location' => $farmer->location,
            'temp' => $weather['main']['temp'] ?? null,
            'description' => $weather['weather'][0]['description'] ?? 'N/A',
            'soil_temp' => $soilTemperature ?? 'N/A',
        ]);
    }

    return response()->json(['error' => 'Weather data not available'], 500);
}



}
