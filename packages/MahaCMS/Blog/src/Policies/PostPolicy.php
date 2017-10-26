<?php

namespace App\Policies;

use MahaCMS\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.create');
    }

}
