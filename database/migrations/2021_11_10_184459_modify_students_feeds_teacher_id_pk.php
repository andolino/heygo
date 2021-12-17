<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStudentsFeedsTeacherIdPk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::statement('ALTER TABLE `student_newsfeed_comments` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_comments` MODIFY `students_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_comments_sub` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_comments_sub` MODIFY `students_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_com_likes` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_com_likes` MODIFY `students_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_com_usefull` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_com_usefull` MODIFY `students_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_likes` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_likes` MODIFY `students_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_usefull` MODIFY `teachers_id` bigint(20) UNSIGNED default null;');
        DB::statement('ALTER TABLE `student_newsfeed_usefull` MODIFY `students_id` bigint(20) UNSIGNED default null;');
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
