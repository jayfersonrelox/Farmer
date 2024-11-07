<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    // Fields that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'crop_types',
        'location',
        'livestock_types',
        'crop_images',       // Updated to handle multiple images
        'livestock_images',  // Updated to handle multiple images
    ];

    // Cast the fields to array for easier access in application logic
    protected $casts = [
        'crop_images' => 'array',        // Automatically decode JSON to PHP array
        'livestock_images' => 'array',   // Automatically decode JSON to PHP array
    ];

}
