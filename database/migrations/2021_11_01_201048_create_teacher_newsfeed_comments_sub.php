<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherNewsfeedCommentsSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_newsfeed_comments_sub', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_newsfeed_comments_id');
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->unsignedBigInteger('students_id')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->foreign('teacher_newsfeed_comments_id', 'fk_tchr_nwsfee_com_sub')->references('id')->on('teacher_newsfeed_comments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('teacher_newsfeed_comments_sub');
    }
}
