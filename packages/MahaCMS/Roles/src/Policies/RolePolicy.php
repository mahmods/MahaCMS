<?php

namespace MahaCMS\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function access($user)
    {
        return User::findOrFail($user->id)->hasAccess('permissions');
    }
    
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('roles.create');
    }

    public function update($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.update');
    }

    public function manage_permissions($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.permissions');
    }

    public function delete($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.delete');
    }
}