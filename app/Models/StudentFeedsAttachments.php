<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeedsAttachments extends Model{
    use HasFactory;

    protected $table = 'student_newsfeed_attachments';
    protected $fillable = [ 'student_newsfeed_id', 'file' ];
}
