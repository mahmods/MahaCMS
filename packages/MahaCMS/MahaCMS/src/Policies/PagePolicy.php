<?php

namespace MahaCMS\MahaCMS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class PagePolicy
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
        return User::findOrFail($user->id)->hasPermission('pages.access');//User::findOrFail($user->id)->hasAccess('roles');
    }
    
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('pages.create');
    }

    public function update($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('pages.manage');
    }

    public function manage_permissions($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('pages.manage');
    }

    public function delete($user, $role)
    {
        return User::findOrFail($user->id)->hasPermission('pages.manage');
    }
}