<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Design;

class DesignRequestController extends Controller
{
    public function store(HttpRequest $request, Design $design)
    {
        // Check if the user has already submitted a request for this design
        $existingRequest = Request::where('user_id', Auth::id())
                                  ->where('design_id', $request->designId)
                                  ->first();

        if ($existingRequest) {
            return redirect()->back()->with('message', 'You have already submitted a request for this design.');
        }

        // Create a new request
        Request::insert([
            'user_id' => Auth::id(),
            'design_id' => $request->designId,
            'description' => $request->description,
            'status' => false,  
        ]);

        return redirect()->back()->with('message', 'Your request has been submitted successfully!');
    }
}
