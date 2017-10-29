<?php

namespace MahaCMS\Blog\Policies;

use MahaCMS\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('categories.access');// User::findOrFail($user->id)->hasAccess('posts');
    }

    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('categories.create');
    }

    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('categories.manage');
    }

    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('categories.manage');
    }

}
