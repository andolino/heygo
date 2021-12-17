<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeds extends Model{
    use HasFactory;

    protected $table = 'student_newsfeed';
    protected $fillable = [ 'student_id', 'feed_title', 'feed_body' ];
}