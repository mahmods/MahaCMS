<?php

namespace MahaCMS\Permissions;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Schema;
use MahaCMS\Permissions\Models\Permission;

class PermissionsChecker extends Facade
{
    public static function check($permissions)
    {
        if (Schema::hasTable('permissions')) {
            foreach ($permissions as $permission) {
                $perm = Permission::where(['perm' => $permission['perm']])->first();
                if (!$perm) {
                    Permission::create([
                        'name'        => $permission['name'],
                        'perm'        => $permission['perm'],
                    ]);
                }
            }
        }
    }
}