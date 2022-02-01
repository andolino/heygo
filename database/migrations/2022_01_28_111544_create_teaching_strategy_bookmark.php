<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingStrategyBookmark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_strategy_bookmark', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->unsignedBigInteger('students_id')->nullable();
            $table->unsignedBigInteger('teaching_strategy_id')->nullable();
            $table->foreign('teachers_id')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teaching_strategy_id')->references('id')->on('teaching_strategy')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('teaching_strategy_bookmark');
    }
}
