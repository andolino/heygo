<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherNewsfeedAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_newsfeed_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_newsfeed_id');
            $table->longText('file');
            $table->timestamps();
            $table->foreign('teacher_newsfeed_id')->references('id')->on('teacher_newsfeed')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_newsfeed_attachments');
    }
}
