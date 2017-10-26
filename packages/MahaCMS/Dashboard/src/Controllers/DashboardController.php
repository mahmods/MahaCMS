<?php

namespace MahaCMS\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use MahaCMS\Dashboard\Widgets;

class DashboardController extends Controller
{
    public function index()
    {
        $widgets = Widgets::get();

        return view('dashboard', ['widgets' => $widgets]);
    }
}
