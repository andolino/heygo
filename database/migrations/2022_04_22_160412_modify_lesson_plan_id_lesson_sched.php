<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLessonPlanIdLessonSched extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::statement('ALTER TABLE heygodb.lesson_schedule DROP INDEX lesson_schedule_lesson_plan_id_foreign;');
        DB::statement('ALTER TABLE heygodb.lesson_schedule DROP COLUMN lesson_plan_id;');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
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
