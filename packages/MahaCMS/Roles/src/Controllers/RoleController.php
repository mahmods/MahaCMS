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
        }
        return response()->json(['authorized' => false]);
    }

    public function create()
    {
        return Role::form();
        $user = Auth::guard('api')->user();
        $request->validate(Role::$rules);
        if ($user->can('create', Role::class)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => ''],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => '']
            ]]);
        }
        return response()->json(['authorized' => false]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $request->validate(Role::$rules);
        if ($user->can('create', Role::class)) {
            $role = new Role($request->all());
            $role->save();
            return response()->json(['success' => true, 'id' => $role->id ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function edit($id)
    {
        return Role::form($id);
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $role)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => $role->name],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $role->description]
            ]]);
        }
        return response()->json(['authorized' => false]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        $request->validate($role->rules());
        if ($user->can('update', $role)) {
            $role->update($request->all());
            return response()->json(['success' => true, 'id' => $role->id ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function managePermissions($id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $role)) {
            $allPermissions = Permission::all();
            $permissions = [];
            for ($i=0; $i < count($allPermissions); $i++) { 
                $c = $role->hasPermission($allPermissions[$i]) ? true : false;
                array_push($permissions, [$allPermissions[$i]->id, $allPermissions[$i]->name,  $c]);
            }
            return response()->json(['permissions' => $permissions]);
        }
        return response()->json(['authorized' => false]);
        
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = Role::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $role)) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                if (in_array($permission->id, $request->all())) {
                    $role->addPermission($permission);
                } else {
                    $role->deletePermission($permission);
                }
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
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
        }
        return response()->json(['authorized' => false]);
    }
}