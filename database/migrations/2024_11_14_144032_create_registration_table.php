<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->id();
            $table->string('university_id_number');
            $table->string('last_name');
            $table->string('first_name');
            $table->date('dateofbirth');
            $table->enum('gender', ['male', 'female']);
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->enum('user_role',['admin','teacher', 'student']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration');
    }
}
