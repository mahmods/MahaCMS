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
        }
        return response()->json(['authorized' => false]);
    }
}