<?php
namespace MahaCMS\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Users\Models\User;
use MahaCMS\Permissions\Models\Permission;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
    	$this->middleware('guest')->except('roles');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password))
        {
            $user->api_token = str_random(60);
            $user->save();
            return response()
                ->json([
                    'authenticated' => true,
                    'api_token' => $user->api_token,
                    'user_id' => $user->id
                ]);
        }
    }

    public function register(Request $request)
    {
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['registered' => true]);
    }

    public function logout(Request $request) 
    {
        
    }

    public function getPermissions()
    {
        $user = Auth::guard('api')->user();
        if($user->superAdmin()) {
            return response()->json(['permissions' => Permission::all()]);
        }
        $allPermissions = [];
        for ($i=0; $i < count($user->roles); $i++) {
            for ($x=0; $x < count($user->roles[$i]->permissions); $x++) { 
                 array_push($allPermissions, $user->roles[$i]->permissions[$x]->perm);
             } 
        }

        // TODO remove duplicate from $allPermissions

        $Permissions = array();
        for ($i=0; $i < count($allPermissions); $i++) { 
            $split = explode(".", $allPermissions[$i]);
            if(!$this->checkPermissionExist($split[0], $Permissions)) {
                $p = new Perm();
                $p->name = $split[0];
                $p->items = [];
                array_push($Permissions, $p);
            }
            array_push($Permissions[count($Permissions)-1]->items, $split[1]);

        }
        return response()->json(['permissions' => $Permissions]);
    }

    protected function checkPermissionExist($text, $array)
    {
        for ($i=0; $i < count($array); $i++) { 
            if($array[$i]->name == $text) {
                return true;
            }
        }
        return false;
    }
}
class Perm {
        public $name;
        public $items;
    }