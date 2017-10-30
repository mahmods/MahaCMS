<?php
namespace MahaCMS\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Users\Models\User;
use MahaCMS\Roles\Models\Role;
use MahaCMS\Profile\Models\Profile;
use Hash;
use Schema;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', User::class)) {
            return response()->json([
                'items' => User::select('id', 'name', 'email')->get(),
                'columns' => [['id', '#'], ['name', 'Name'], ['email', 'Email']]
                ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function create()
    {
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('create', User::class)) {
            return User::form();
        }
        return response()->json(['authorized' => false]);
    }

    public function store(Request $request)
    {
        $this->authorize('create5', User::class);
        $user = Auth::guard('api')->user();

        if ($user->can('create', User::class)) {
            $request->validate([
                'name' => 'required|max:60',
                'email' => 'required|email|unique:users',
                'password' => 'required|between:6,18|confirmed'
            ]);
            $newUser = new User($request->all());
            $newUser->password = bcrypt($request->password);
            $newUser->save();

            $profile = new Profile(['user_id' => $newUser->id]);
            $profile->first_name = $newUser->name;
            $profile->save();
    
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('update', $user)) {
            return User::form($user);
        }
        return response()->json(['authorized' => false]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('update', $user)) {
            $request->validate([
                'name' => 'required|max:60',
                'email' => 'required|email|unique:users',
                'password' => 'required|between:6,18|confirmed'
            ]);
            $user->update($request->all());
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('delete', $user)) {
            $user->delete();
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function manageRoles($id)
    {
        $user = User::find($id);
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('delete', $user)) {
            $allRoles = Role::all();
            $roles = [];
            for ($i=0; $i < count($allRoles); $i++) { 
                $c = $allRoles[$i]->hasUser($user) ? true : false;
                array_push($roles, [$allRoles[$i]->id, $allRoles[$i]->name,  $c]);
            }
            return response()->json(['roles' => $roles]);
        }
        return response()->json(['authorized' => false]);
        
    }

    public function updateRoles(Request $request, $id)
    {
        $user = User::find($id);
        $userForAuth = Auth::guard('api')->user();
        if ($userForAuth->can('update', $user)) {
            $roles = Role::all();
            foreach ($roles as $role) {
                if (in_array($role->id, $request->all())) {
                    $role->addUser($user);
                } else {
                    $role->deleteUser($user);
                }
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
    }
}