<?php

namespace MahaCMS\Profile\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Profile\Models\Profile;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::guard('api')->user();
        if($user) {
            return response()->json(['profile' => $user->profile]);
        }
        return response()->json(['authorized' => false]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            //dd($request['id']);
            Profile::find($request['id'])->update($request->all());
            //DB::table('profile')->where('user_id', $request['user_id'])->update($request->all());
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
    }
}