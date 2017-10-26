<?php

namespace MahaCMS\Permissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Permissions\Models\Permission;
use Auth;

class PermissionController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', Permission::class)) {
            return response()->json([
                'items' => Permission::select('id', 'name', 'perm')->get(),
                'columns' => [['id', '#'], ['name', 'Name'], ['perm', 'Short']]
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
        if ($user->can('create', Permission::class)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => ''],
                ['name' => 'perm', 'label' => 'Short', 'type' => 'text', 'value' => '']
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
        if ($user->can('create', Permission::class)) {
            $permission = new Permission($request->all());
            $permission->save();
    
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $permission)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => $permission->name],
                ['name' => 'perm', 'label' => 'Short', 'type' => 'text', 'value' => $permission->perm]
            ]]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $permission)) {
            $permission->update($request->all());
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }
}