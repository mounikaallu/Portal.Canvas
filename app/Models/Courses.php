<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester',
        'course_name',
        'course_desc',
    ];

    // Define the many-to-many relationship with teachers
    public function teachers()
    {
        return $this->belongsToMany(Registration::class, 'course_teacher', 'course_id', 'teacher_id');
    }
    // Relationship for students enrolled in a course
    public function enrolledStudents()
    {
        return $this->belongsToMany(Registration::class, 'course_student_teacher', 'course_id', 'student_id')
                    ->withPivot('teacher_id');
    }

    // Relationship for teachers indirectly assigned to students through the course-student-teacher table
    public function teachingTeachers()
    {
        return $this->belongsToMany(Registration::class, 'course_student_teacher', 'course_id', 'teacher_id');
    }

}
