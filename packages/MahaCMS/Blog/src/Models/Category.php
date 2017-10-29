<?php

namespace MahaCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Blog\Models\Post;

class Category extends Model
{
    protected $fillable = ['name'];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}