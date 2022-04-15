<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentNewsfeedCommentsSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_newsfeed_comments_sub', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_newsfeed_comments_id');
            $table->unsignedBigInteger('teachers_id');
            $table->unsignedBigInteger('students_id');
            $table->longText('comments');
            $table->foreign('student_newsfeed_comments_id', 'fk_stdnt_nwsfee_com_sub')->references('id')->on('student_newsfeed_comments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teachers_id')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_newsfeed_comments_sub');
    }
}
