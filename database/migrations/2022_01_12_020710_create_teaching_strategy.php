<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingStrategy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_strategy', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('lesson_plan_id')->nullable();
            $table->unsignedBigInteger('students_level_id')->nullable();
            $table->string('description');
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('students_level_id')->references('id')->on('students_level')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('teaching_strategy');
    }
}
