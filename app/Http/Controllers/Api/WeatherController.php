<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
    {
        $city = $request->input('city', 'Manila'); // Default to Manila if no city is provided
        $weather = $this->weatherService->getWeather($city);

        if ($weather) {
            return view('weather.show', ['weather' => $weather]);
        }

        return redirect()->back()->withErrors(['message' => 'Unable to fetch weather data.']);
    }
}
