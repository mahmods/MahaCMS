<?php
namespace MahaCMS\MahaCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\MahaCMS\Menu;

class PackagesController extends Controller
{
    public function all()
    {
        $Menu = Menu::generate();
        return response()->json(['menu' => $Menu]);
    }
}
