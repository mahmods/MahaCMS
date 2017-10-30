<?php

namespace MahaCMS\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use MahaCMS\Blog\Models\Post;
use MahaCMS\Profile\Models\Profile;
use MahaCMS\Roles\Traits\HasRolesAndPermissions;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
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
                    'innerType' => 'email',
                    'label' => 'Email Address',
                    'model' => 'email',
                    'value' => $model ? $model->email : ''
                ),
                array(
                    'type' => 'input',
                    'innerType' => 'password',
                    'label' => 'Password',
                    'model' => 'password',
                    'value' => ''
                ),
                array(
                    'type' => 'input',
                    'innerType' => 'password',
                    'label' => 'Password Confirmation',
                    'model' => 'password_confirmation',
                    'value' => ''
                ),
            ]
        ));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function superAdmin()
    {
        return in_array($this->email, config('mahacms.superadmins'));
    }
}
