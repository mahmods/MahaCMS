<?php

namespace MahaCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Users\Models\User;
use MahaCMS\Blog\Models\Category;

class Post extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title', 'description', 'content', 'image'];   
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}