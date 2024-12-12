<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Registration;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('registration');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'university_id' => 'required|numeric',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'dateofbirth' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Store the user data
        Registration::create([
            'university_id_number' => $request->university_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'dateofbirth' => $request->dateofbirth,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

           // Redirect to login page with success message
    return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
