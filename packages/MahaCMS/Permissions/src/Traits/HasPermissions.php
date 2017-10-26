<?php

namespace MahaCMS\Permissions\Traits;

use MahaCMS\Permissions\Models\Permission;

trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }

    public function hasPermission($permission)
    {
        $permission = Permission::where(['perm' => $permission])->first();

        if ($permission) {
            foreach ($this->permissions as $p) {
                if ($p->id == $permission->id) {
                    return true;
                }
            }
        }

        return false;
    }

    
}