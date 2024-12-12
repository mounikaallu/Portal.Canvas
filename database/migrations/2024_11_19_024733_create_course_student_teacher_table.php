<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudentTeacherTable extends Migration
{
    public function up()
    {
        Schema::create('course_student_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('registrations')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('registrations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_student_teacher');
    }
}
