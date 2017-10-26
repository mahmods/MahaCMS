<?php

namespace MahaCMS\Permissions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class PermissionPolicy
{
    //use HandlesAuthorization;

    public function access($user)
    {
        return User::findOrFail($user->id)->hasAccess('permissions');
    }

    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('permissions.create');
    }

    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('permissions.update');
    }

    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('permissions.delete');
    }
}