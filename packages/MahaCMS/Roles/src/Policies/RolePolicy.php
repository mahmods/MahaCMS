<?php

namespace MahaCMS\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class RolePolicy
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
        return User::findOrFail($user->id)->hasPermission('roles.access');//User::findOrFail($user->id)->hasAccess('roles');
    }
    
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('roles.create');
    }

    public function update($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.manage');
    }

    public function manage_permissions($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.manage');
    }

    public function delete($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('roles.manage');
    }
}