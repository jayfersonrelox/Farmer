<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Support\Facades\Storage;

class FarmerController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:farmers|max:255',
            'phone' => 'required|string|max:20',
            'crop_types' => 'required|string',
            'livestock_types' => 'required|string',
            'crop_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'livestock_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Define the paths
        $cropImagesPath = public_path('images/crops');
        $livestockImagesPath = public_path('images/livestock');

        // Create directories if they do not exist
        if (!file_exists($cropImagesPath)) {
            mkdir($cropImagesPath, 0777, true);
        }
        if (!file_exists($livestockImagesPath)) {
            mkdir($livestockImagesPath, 0777, true);
        }

        // Handle image upload for crop types
        $cropImagePaths = [];
        if ($request->hasFile('crop_images')) {
            foreach ($request->file('crop_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($cropImagesPath, $filename);
                $cropImagePaths[] = 'images/crops/' . $filename;
            }
        }

        // Handle image upload for livestock types
        $livestockImagePaths = [];
        if ($request->hasFile('livestock_images')) {
            foreach ($request->file('livestock_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($livestockImagesPath, $filename);
                $livestockImagePaths[] = 'images/livestock/' . $filename;
            }
        }

        // Store farmer information
        Farmer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'crop_types' => $request->input('crop_types'),
            'location' => $request->input('location'),
            'livestock_types' => $request->input('livestock_types'),
            'crop_images' => json_encode($cropImagePaths), // Store as JSON
            'livestock_images' => json_encode($livestockImagePaths), // Store as JSON
        ]);

        return redirect()->back()->with('success', 'Information submitted successfully.');
    }



    public function farmerdata(){
        $uniqueCropTypesCount = Farmer::distinct('crop_types')->count('crop_types');
        return view ('User.farmerdata',compact('uniqueCropTypesCount'));
    }
}
