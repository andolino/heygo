<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSchedule extends Model{
    
    use HasFactory;

    protected $table = 'lesson_schedule';
    
    protected $fillable = ['lesson_plan_id', 'students_id', 'lesson_date', 'status', 
                                'new_lesson_schedule_id', 'created_at', 'updated_at', 
                                    'lesson_option_id', 'teachers_id', 'contact_no', 
                                        'communication_app_id', 'app_id'];



}
