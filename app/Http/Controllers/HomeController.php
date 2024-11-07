<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Models\Farmer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        // Retrieve the count of feedbacks
        $feedbackCount = Feedback::count();
        $uniqueCropTypesCount = Farmer::distinct('crop_types')->count('crop_types');
        $uniqueLivestockCount = Farmer::distinct('livestock_types')->count('livestock_types');


        // Pass the count to the view
        return view('User.home', compact('feedbackCount','uniqueCropTypesCount','uniqueLivestockCount'));
    }


    public function feedback() {

        $feedbacks = Feedback::all();


        $feedbackCount = $feedbacks->count();


        return view('User.feedback', [
            'feedbacks' => $feedbacks,
            'feedbackCount' => $feedbackCount
        ]);
    }


}
