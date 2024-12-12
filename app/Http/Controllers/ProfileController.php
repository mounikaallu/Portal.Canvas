<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Registration;

class ProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        $userEmail = $request->query('user_email'); 
        Log::info("User email received: " . $userEmail); 

        // Find user by email
        $user = Registration::where('email', $userEmail)->first();

        if ($user) {
            return view('profile', compact('user'));
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function updateProfile(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dateofbirth' => 'required|date',
            'mobile_number' => 'required|string|max:15',
        ]);

        // Find the user by email
        $user = Registration::where('email', $request->input('email'))->first();

        if ($user) {
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'dateofbirth' => $request->input('dateofbirth'),
                'mobile_number' => $request->input('mobile_number'),
            ]);
    
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        } else {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
    }
}
