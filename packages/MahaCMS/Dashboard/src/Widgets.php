<?php

namespace MahaCMS\Dashboard;

use Illuminate\Support\Facades\Facade;
use MahaCMS\MahaCMS\Packages;

class Widgets extends Facade
{
    public static function get()
    {
        $widgets = [];
        foreach (Packages::all() as $package) {
            $dir = __DIR__.'/../../'.$package.'/src';
            $files = is_dir($dir) ? scandir($dir) : [];

            foreach ($files as $file) {
                if ($file == 'Widgets.json') {
                    $file_r = file_get_contents($dir.'/'.$file);
                    foreach (json_decode($file_r, true) as $w) {
                        $w['package'] = $package;
                        array_push($widgets, $w);
                    }
                    break;
                }
            }
        }

        return $widgets;
    }
}
