<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $feedbacks = Feedback::all();


        $feedbackCount = $feedbacks->count();
         return view('User.feedback', [
            'feedbacks' => $feedbacks,
            'feedbackCount' => $feedbackCount
        ]);
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Create a new feedback record
        Feedback::create($validated);

        // Redirect or respond with a success message
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    $feedback = Feedback::findOrFail($id);
    $feedback->update($request->all());

    return redirect()->back()->with('success', 'Feedback updated successfully.');
}
public function destroy($id)
{
    $feedback = Feedback::findOrFail($id);
    $feedback->delete();

    return redirect()->back()->with('success', 'Feedback deleted successfully.');
}

}
