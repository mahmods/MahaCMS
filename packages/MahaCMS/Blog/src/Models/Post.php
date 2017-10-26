<?php

namespace MahaCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Users\Models\User;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'content',];   
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}