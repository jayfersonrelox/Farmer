<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Farmer;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{


    public function admindash() {
        // Retrieve all farmers
        $farmers = Farmer::all();

        // Unique crop types count
        $uniqueCropTypesCount = Farmer::distinct('crop_types')->count('crop_types');

        // Additional statistics
        $totalFarmersCount = $farmers->count();

        // Count of crop images
        $totalCropImagesCount = Farmer::whereNotNull('crop_images')->count();

        // Count of livestock types (assuming you want to count unique types)
        $uniqueLivestockTypesCount = Farmer::distinct('livestock_types')->count('livestock_types');

        // Farmers grouped by location
        $farmersByLocation = Farmer::select('location', DB::raw('count(*) as total'))
                                    ->groupBy('location')
                                    ->get();

        // Crop type distribution
        $cropDistribution = Farmer::select('crop_types', DB::raw('count(*) as total'))
                                  ->groupBy('crop_types')
                                  ->get();

        // Recent registrations (adjust the query according to your registration date field)
        $recentRegistrationsCount = Farmer::where('created_at', '>=', now()->subMonth())->count();

        // Identify the most affected location dynamically
        $susceptibleCrops = ['corn', 'wheat', 'rice']; // Add other susceptible crop types

        $mostAffectedLocation = Farmer::select('location', DB::raw('count(*) as affected_count'))
            ->whereIn('crop_types', $susceptibleCrops)
            ->groupBy('location')
            ->orderBy('affected_count', 'desc')
            ->first();

        // Fetch weather prediction for tomorrow
        $apiKey = env('WEATHER_API_KEY'); // Use the API key from the .env file
        $city = 'Oriental Mindoro'; // City for the weather data
        $response = Http::get(env('WEATHER_API_URL') . "/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        $weatherData = $response->json();

        // Extract relevant weather information
        $tomorrowWeather = [
            'temperature' => $weatherData['main']['temp'] ?? null,
            'description' => $weatherData['weather'][0]['description'] ?? null,
            'icon' => $weatherData['weather'][0]['icon'] ?? null, // Extract the icon code
        ];


        return view('Admin.dashboard', compact(
            'uniqueCropTypesCount',
            'totalFarmersCount',
            'totalCropImagesCount',
            'uniqueLivestockTypesCount',
            'farmers',
            'farmersByLocation',
            'cropDistribution',
            'recentRegistrationsCount',
            'mostAffectedLocation',
            'tomorrowWeather' // Pass weather data to the view
        ));
    }






    public function farmersCrops(){
        $uniqueCropTypesCount = Farmer::distinct('crop_types')->count('crop_types');
        $farmers = Farmer::all();
        $farmersByLocation = Farmer::select('location', DB::raw('count(*) as total'))
        ->groupBy('location')
        ->get();
        $cropDistribution = Farmer::select('crop_types', DB::raw('count(*) as total'))
        ->groupBy('crop_types')
        ->get();

// Recent registrations (adjust the query according to your registration date field)
$recentRegistrationsCount = Farmer::where('created_at', '>=', now()->subMonth())->count();
        return view ('Admin.FarmerCrops',compact('farmers','uniqueCropTypesCount','cropDistribution','farmersByLocation'));
    }
    public function ViewAllCrops() {
        // Fetch all farmers' crop data
        $farmers = Farmer::all(); // Get all farmers from the table

        return view('Admin.ViewAllCrops', compact('farmers')); // Pass $farmers to the view
    }



    public function testimonials(){
        $farmersByLocation = Farmer::select('location', DB::raw('count(*) as total'))
        ->groupBy('location')
        ->get();
        $cropDistribution = Farmer::select('crop_types', DB::raw('count(*) as total'))
        ->groupBy('crop_types')
        ->get();

// Recent registrations (adjust the query according to your registration date field)
$recentRegistrationsCount = Farmer::where('created_at', '>=', now()->subMonth())->count();
        $farmers = Farmer::all(); // Get all farmers from the table
        $feedbacks = Feedback::all();
        return view ('Admin.Testimonials',compact('feedbacks','farmers','farmersByLocation','cropDistribution','recentRegistrationsCount'));
    }
}
