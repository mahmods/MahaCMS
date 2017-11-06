<?php

namespace MahaCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Users\Models\User;
use MahaCMS\Blog\Models\Category;
use Auth;

class Post extends Model
{
    protected $fillable = ['title', 'category_id', 'image', 'description', 'content', 'user_id'];   
    
    public static function form($model = null)
    {
        $user = Auth::guard('api')->user();
        return json_encode(array(
            'form' => [
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Title',
                    'model' => 'title',
                    'value' => $model ? $model->title : ''
                ),
                array(
                    'type' => 'select',
                    'label' => 'Category',
                    'model' => 'category_id',
                    'value' => $model ? $model->category_id : '',
                    'options' => Category::select('id', 'name')->get()
                ),
                array(
                    'type' => 'image',
                    'label' => 'Image',
                    'model' => 'image',
                    'value' => $model ? $model->image : ''
                ),
                array(
                    'type' => 'textarea',
                    'label' => 'Description',
                    'model' => 'description',
                    'value' => $model ? $model->description : ''
                ),
                array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'model' => 'content',
                    'value' => $model ? $model->content : '',
                    'editor' => true
                ),
                array(
                    'model' => 'user_id',
                    'value' => $model ? $model->user_id : $user->id
                ),
            ]
        ));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}