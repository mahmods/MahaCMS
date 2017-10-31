<?php

namespace MahaCMS\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Permissions\Traits\HasPermissions;
use MahaCMS\Permissions\Models\Permission;

class Role extends Model
{
    use HasPermissions;
    protected $fillable = ['name', 'description'];

    public static function form()
    {
        return json_encode(array(
            'form' => [
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Name',
                    'model' => 'name',
                    'value' => ''
                ),
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Description',
                    'model' => 'description',
                    'value' => ''
                ),
            ]
        ));
    }

    public function users()
    {
        return $this->belongsToMany('MahaCMS\Users\Models\User', 'role_users');
    }

    public function hasUser($user)
    {
        return RoleUser::where(
                ['role_id' => $this->id, 'user_id' => $user->id]
            )->first();
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        $p = [];
        foreach ($permissions as $permission) {
            if($this->hasPermission($permission)) {
                array_push($p, $permission);
            }
        }
        return $p;
    }

    public function hasPermission($permission)
    {
        return PermissionRole::where(
                ['role_id' => $this->id, 'permission_id' => $permission->id]
            )->first();
    }

    public function addUser($user)
    {
        if (!$this->hasUser($user)) {
            return RoleUser::create(['role_id' => $this->id, 'user_id' => $user->id]);
        }
        return false;
    }

    public function addPermission($permission)
    {
        if (!$this->hasPermission($permission)) {
            return PermissionRole::create(['role_id' => $this->id, 'permission_id' => $permission->id]);
        }
        return false;
    }

    public function addUsers($users)
    {
        foreach ($users as $user) {
            $this->addUser($user);
        }
        return true;
    }

    public function addPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->addPermission($permission);
        }
        return true;
    }

    public function deleteUser($user)
    {
        if ($this->hasUser($user)) {
            return RoleUser::where(
                    ['role_id' => $this->id, 'user_id' => $user->id]
                )->first()->delete();
        }
        return false;
    }

    public function deletePermission($permission)
    {
        if ($this->hasPermission($permission)) {
            return PermissionRole::where(
                    ['role_id' => $this->id, 'permission_id' => $permission->id]
                )->first()->delete();
        }
        return false;
    }

    public function deleteUsers($users)
    {
        foreach ($users as $user) {
            $this->deleteUser($user);
        }
        return true;
    }

    public function deletePermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->deletePermission($permission);
        }
        return true;
    }
}
