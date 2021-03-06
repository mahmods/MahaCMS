<?php
namespace MahaCMS\MahaCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NavigationController extends Controller
{
    public function get()
    {
        return DB::table('nav')->select(['name', 'url'])->get();
    }
    
    public function update(Request $request)
    {
        if (count($request->all()) < 1) {
            return response()->json(['message' => 'Navigation must have at least one item.'], 422);
        }
        $request->validate([
            "items.*" => 'required|array|min:1|distinct',
            'items.*.name' => 'distinct|required',
            'items.*.url' => 'distinct|required'
        ]);
        DB::table('nav')->truncate();
        if (DB::table('nav')->insert($request->items)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
