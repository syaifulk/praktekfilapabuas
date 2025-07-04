<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    //
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 
                            'published', 'published_at', 'user_id'];

    public function categories()
    
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    
    {
        return $this->belongsTo(User::class);
    }
}
