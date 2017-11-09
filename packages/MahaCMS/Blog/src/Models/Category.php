<?php

namespace MahaCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Blog\Models\Post;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public static $rules = [
        'name' => 'required',
        'slug' => 'required|unique:categories'
    ];

    public static function form($model = null)
    {
        return json_encode(array(
            'form' => [
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Name',
                    'model' => 'name',
                    'value' => $model ? $model->name : ''
                ),
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Slug',
                    'model' => 'slug',
                    'value' => $model ? $model->slug : ''
                )
            ]
        ));
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}