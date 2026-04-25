<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostRevision extends Model
{
      protected $fillable = [
        'post_id',
        'user_id',
        'title',
        'content'
    ];
}
