<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    // Fetch all teachers
    public function getTeachers()
    {
        $teachers = Registration::where('user_role', 'teacher')->get();
        return response()->json(['teachers' => $teachers]);
    }
    public function onboardTeacher(Request $request)
    {
        // Log the incoming request
        Log::info('Incoming Onboard Teacher Request:', $request->all());
    
        try {
            // Validate input data
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dateofbirth' => 'required|date',
                'email' => 'required|email|unique:registrations,email',
                'mobile_number' => 'required|string|regex:/^\d{10,15}$/',
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:teacher',
            ]);
    
            // Store the new teacher in the database
            Log::info("Validated Data:", $validated);
    
            $teacher = Registration::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'dateofbirth' => $validated['dateofbirth'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'password' => bcrypt($validated['password']), // Hash the password
                'user_role' => $validated['role'], // Default role: teacher
            ]);
    
            Log::info('Teacher Successfully Onboarded:', [$teacher]);
    
            return response()->json(['success' => true, 'teacher' => $teacher]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation Errors:', $e->errors());
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any other errors
            Log::error('Onboarding Teacher Error:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Internal server error'], 500);
        }
    }
    

    // Update teacher details
    public function updateTeacher(Request $request)
    {
        $teacher = Registration::find($request->id);

        if ($teacher) {
            $teacher->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dateofbirth' => $request->dateofbirth,
                'mobile_number' => $request->mobile_number,
            ]);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Teacher not found']);
        }
    }
}
