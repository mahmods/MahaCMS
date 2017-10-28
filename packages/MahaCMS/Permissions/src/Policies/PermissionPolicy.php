<?php

namespace MahaCMS\Permissions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class PermissionPolicy
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
        return User::findOrFail($user->id)->hasPermission('permissions.access');// User::findOrFail($user->id)->hasAccess('permissions');
    }
}