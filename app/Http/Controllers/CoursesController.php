<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Registration;

class CoursesController extends Controller
{
    public function getCourses()
    {
        $courses = Courses::with('teachers')->get();
        return response()->json(['courses' => $courses]);
    }

    public function addCourse(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_desc' => 'nullable|string',
            'semester' => 'required|string|max:20',
        ]);

        $course = Courses::create([
            'course_name' => $validated['course_name'],
            'course_desc' => $validated['course_desc'],
            'semester' => $validated['semester'],
        ]);

        return response()->json(['success' => true, 'course' => $course]);
    }

    public function assignTeachers(Request $request, $courseId)
    {
        $course = Courses::find($courseId);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $course->teachers()->sync($request->teacher_ids);

        return response()->json(['success' => true, 'course' => $course->load('teachers')]);
    }

    public function fetchTeachers()
    {
        $teachers = Registration::where('user_role', 'teacher')->get();
        return response()->json(['teachers' => $teachers]);
    }
    
}
