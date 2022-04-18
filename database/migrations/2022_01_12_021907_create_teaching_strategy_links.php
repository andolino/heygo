<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingStrategyLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_strategy_links', function (Blueprint $table) {
            $table->id();
            $table->string('links')->nullable();
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
        Schema::dropIfExists('teaching_strategy_links');
    }
}
