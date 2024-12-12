<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'university_id_number',
        'last_name',
        'first_name',
        'dateofbirth',
        'gender',
        'mobile_number',
        'email',
        'password',
        'user_role',
    ];

    //many-to-many relationship with courses
    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'course_teacher', 'teacher_id', 'course_id');
    }

    // Relationship for courses a teacher is assigned to
    public function teachingCourses()
    {
        return $this->belongsToMany(Courses::class, 'course_student_teacher', 'teacher_id', 'course_id');
    }

    // Relationship for courses a student is enrolled in
    public function enrolledCourses()
    {
        return $this->belongsToMany(Courses::class, 'course_student_teacher', 'student_id', 'course_id');
    }
}