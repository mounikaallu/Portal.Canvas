<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Registration;
class LoginController extends Controller
{
   /* To display Login form*/
    public function showLoginForm()
    {
        return view('login');  
    }
    /* validate login details with database*/ 

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => '*Please enter your email address.',
            'email.email' => '*Please enter a valid email address.',
            'password.required' => '*Please enter your password.',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = Registration::where('email', $email)->first();

        if ($user) {
            // Ensure to use hashed password check
            if (password_verify ($password, $user->password)) {
                 // Store user data in the session
                $request->session()->put('user', $user);

                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid Credentials');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid Email');
        }
    }

}