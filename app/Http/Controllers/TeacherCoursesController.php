<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Registration;
use Illuminate\Support\Facades\Log;
class TeacherCoursesController extends Controller
{
    public function getAssignedCourses(Request $request)
    {
        $teacherId = $request->input('teacher_id'); 
        $assignedCourses = Courses::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('registrations.id', $teacherId); 
        })->get();
    
        return response()->json(['courses' => $assignedCourses]);
    }
    
}
