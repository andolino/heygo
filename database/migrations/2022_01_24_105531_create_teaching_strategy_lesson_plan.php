<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingStrategyLessonPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_strategy_lesson_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaching_strategy_id')->nullable();
            $table->unsignedBigInteger('lesson_plan_id')->nullable();
            $table->foreign('teaching_strategy_id')->references('id')->on('teaching_strategy')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('teaching_strategy_lesson_plan');
    }
}
