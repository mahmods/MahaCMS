<?php

namespace MahaCMS\Blog\Policies;

use MahaCMS\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function access($user)
    {
        return User::findOrFail($user->id)->hasAccess('posts');
    }

    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('posts.create');
    }

    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('posts.manage');
    }

    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('posts.manage');
    }

}
