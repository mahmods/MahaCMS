<?php

namespace MahaCMS\Settings\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Settings\Models\Setting;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    public function getSettings()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', Setting::class)) {
            return response()->json(['settings' => Setting::all()]);
        }
        return response()->json(['authorized' => false]);
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', Setting::class)) {
            foreach ($request->all() as $row) {
                DB::table('settings')->where('id', $row['id'])->update($row);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
    }
}