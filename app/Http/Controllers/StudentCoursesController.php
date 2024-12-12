<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Registration;
use Illuminate\Support\Facades\Log;
class StudentCoursesController extends Controller
{
    public function getSemesterDropdown()
    {
        $semesters = Courses::distinct()->pluck('semester');
        $html = view('student.available-courses', compact('semesters'))->render();
        return response()->json(['html' => $html]);
    }

    public function getCoursesBySemester(Request $request)
    {
            $semester = $request->input('semester');

            if (!$semester) {
                return response()->json(['error' => 'Semester is required'], 400);
            }
            $courses = Courses::with('teachers')->where('semester', $semester)->get();

            return response()->json(['courses' => $courses]);
    }
    public function registerForCourse(Request $request)
    {
        $studentId = $request->input('student_id');
        $courseId = $request->input('course_id');
        $teacherId = $request->input('teacher_id');

        Log::info(["student id", $studentId]);

        // Check if the student is already registered for the course
        $existingRegistration = DB::table('course_student_teacher')
            ->where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this course'
            ], 400); // Return a 400 status code for bad request
        }

        // Add entry to the pivot table
        DB::table('course_student_teacher')->insert([
            'course_id' => $courseId,
            'student_id' => $studentId,
            'teacher_id' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registered successfully'
        ]);
    }

    public function getRegisteredCourses(Request $request)
    {
        $studentId = $request->input('student_id');
        $registeredCourses = DB::table('course_student_teacher')
            ->join('courses', 'courses.id', '=', 'course_student_teacher.course_id')
            ->join('registrations', 'registrations.id', '=', 'course_student_teacher.teacher_id')
            ->where('course_student_teacher.student_id', $studentId)
            ->select('courses.course_name', 'courses.course_desc', 'registrations.first_name as teacher_name', 'courses.semester')
            ->get();
        return response()->json(['courses' => $registeredCourses]);
    }


}