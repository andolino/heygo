<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentNewsfeedAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_newsfeed_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_newsfeed_id');
            $table->longText('file');
            $table->foreign('student_newsfeed_id')->references('id')->on('student_newsfeed')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('student_newsfeed_attachments');
    }
}
