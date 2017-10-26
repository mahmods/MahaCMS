<?php
namespace MahaCMS\MahaCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\MahaCMS\Packages;

class PackagesController extends Controller
{
    public function __construct()
    {
    	//$this->middleware('auth:api')->except('index');
    }
    public function all()
    {
        $packages = Packages::all();

        return response()->json([
            'packages' => $packages
        ]);
    }
}
