<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    

   use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'published_at'
    ];


public function user ()
{
    return $this->belongsTo(User::class);
}

public function categories()
{
    return $this->belongsToMany(Category::class);
}

public function tags()
{
 return $this->belongsToMany(Tag::class);
}



public function scopeInCategory($query, string $slug)
{
    return $query->whereHas('categories', function ($q) use ($slug) {
        $q->where('slug', $slug);
    });
}

public function scopeWithTag($query, string $slug)
{
    return $query->whereHas('tags', function ($q) use ($slug) {
        $q->where('slug', $slug);
    });
}


}


