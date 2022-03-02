<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingStrategyVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_strategy_videos', function (Blueprint $table) {
            $table->id();
            $table->string('videos')->nullable();
            $table->unsignedBigInteger('teaching_strategy_id')->nullable();
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
        Schema::dropIfExists('teaching_strategy_videos');
    }
}
