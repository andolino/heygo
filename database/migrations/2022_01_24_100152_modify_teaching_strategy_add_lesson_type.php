<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTeachingStrategyAddLessonType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teaching_strategy', function (Blueprint $table) {
            $table->tinyInteger('lesson_type')->default(0)->comment('0 => Lesson Plan, 1 => Teaching Strategy');
        });
        DB::statement('ALTER TABLE `teaching_strategy` MODIFY COLUMN lesson_type tinyint(4) AFTER id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
