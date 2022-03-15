<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Messages extends Authenticatable{
    // use HasFactory;
    use Notifiable;

    protected $guard = 'Messages';
    
    protected $fillable = [
        'students_id', 'teachers_id', 'messages', 'is_teacher', 'created_at', 'updated_at'
    ];

}
