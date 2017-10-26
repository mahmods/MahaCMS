<?php

namespace MahaCMS\Roles\Traits;

use MahaCMS\Roles\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function hasRole(Role $role)
    {
        $role = Role::where(['name' => $role])->firstOrFail();

        if ($role) {
            foreach ($this->roles as $r) {
                if ($r->id == $role->id) {
                    return true;
                }
            }
        }

        return false;
    }
}