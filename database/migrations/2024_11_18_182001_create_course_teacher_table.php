<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTeacherTable extends Migration
{
    public function up()
    {
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('registrations')->onDelete('cascade'); // Assuming teachers are stored in 'registrations' table
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_teacher');
    }
}