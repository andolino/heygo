<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherNewsfeedComLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_newsfeed_com_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_newsfeed_com_id');
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->unsignedBigInteger('students_id')->nullable();
            $table->timestamps();
            $table->foreign('teacher_newsfeed_com_id')->references('id')->on('teacher_newsfeed_comments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teachers_id')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_newsfeed_com_likes');
    }
}
