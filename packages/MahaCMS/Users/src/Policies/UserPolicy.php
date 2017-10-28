<?php

namespace MahaCMS\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class UserPolicy
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
        return User::findOrFail($user->id)->hasPermission('users.access');//User::findOrFail($user->id)->hasAccess('users');
    }

    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('users.create');
    }

    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('users.manage');
    }

    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('users.manage');
    }
}