<?php

namespace MahaCMS\MahaCMS;

use Illuminate\Support\Facades\Facade;

class Packages extends Facade
{
    public static function get()
    {
        $packages = [];
        $location = __DIR__.'/../../';

        $files = is_dir($location) ? scandir($location) : [];

        foreach ($files as $package) {
            if ($package != '.' and $package != '..' and ucfirst($package) != 'MahaCMS' and ucfirst($package) != 'Users') {
                array_push($packages, strtolower($package));
            }
        }

        return $packages;
    }

    public static function all()
    {
        $packages = [];
        foreach (static::get() as $package) {
            $items = [];
            $dir = __DIR__.'/../../'.$package.'/src';
            $files = is_dir($dir) ? scandir($dir) : [];
            foreach ($files as $file) {
                if ($file == 'Package.json') {
                    $file_r = file_get_contents($dir.'/'.$file);
                    foreach (json_decode($file_r, true) as $w) {
                        array_push($items,  $w);
                    }
                    break;
                }
            }
            array_push($packages, ['name' => $package, 'items' => $items]);
        }
        

        $preference = collect($packages);

        return $preference->toArray();
    }
}