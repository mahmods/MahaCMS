<?php

namespace MahaCMS\Roles\Traits;

use MahaCMS\Permissions\Models\Permission;

trait HasRolesAndPermissions
{
    use HasRoles;

    public function hasPermission($permission)
    {
        $permission = Permission::where(['perm' => $permission])->first();

        if ($permission) {
            foreach ($this->roles as $role) {
                if ($role->hasPermission($permission)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasAccess($permission)
    {
        //$permissions = Permission::all();
        foreach ($this->roles as $role) {
            //dd($role->getPermissions());
            foreach ($role->getPermissions() as $p) {
                if(substr($p->perm, 0, strlen($permission)) === $permission) {
                    return true;
                }
            }
        }
        return false;
    }
}