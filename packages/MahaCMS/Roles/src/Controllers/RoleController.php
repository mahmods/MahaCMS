<?php

namespace MahaCMS\Roles\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Roles\Models\Role;
use MahaCMS\Permissions\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', Role::class)) {
            return response()->json([
                'items' => Role::select('id', 'name', 'description')->get(),
                'columns' => [['id', '#'], ['name', 'Name'], ['description', 'Description']]
                ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function create()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Role::class)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => ''],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => '']
            ]]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Role::class)) {
            $role = new Role($request->all());
            $role->save();
    
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $role)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => $role->name],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $role->description]
            ]]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $role)) {
            $role->update($request->all());
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function permissions($id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('manage_permissions', $role)) {
            return response()->json([
                'permissions' => $role->permissions,
                'role' => $role->name
                ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function updatePermissions(Request $request, Role $role, $id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('manage_permissions', $role)) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                if (array_key_exists($permission->id, $request->all())) {
                    $role->addPermission($permission);
                } else {
                    $role->deletePermission($permission);
                }
            }
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('delete', $role)) {
            $role->deletePermissions($role->permissions);
            $role->deleteUsers($role->users);
            $role->delete();
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }
}