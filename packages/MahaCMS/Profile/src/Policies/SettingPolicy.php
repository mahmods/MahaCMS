<?php

namespace MahaCMS\Settings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MahaCMS\Users\Models\User;

class SettingPolicy
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
        dd(5);
        return User::findOrFail($user->id)->hasPermission('settings.access');
    }
}