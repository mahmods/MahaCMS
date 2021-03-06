<?php

namespace MahaCMS\MahaCMS;

use Illuminate\Support\Facades\Facade;

class Packages extends Facade
{
    /**
     * Returns an array of all the installed packages.
     */
    public static function get()
    {
        // Check for Laralum packages
        $packages = [];
        $location = __DIR__.'/../../';
        $files = is_dir($location) ? scandir($location) : [];

        foreach ($files as $package) {
            if ($package != '.' and $package != '..' and ucfirst($package) != 'MahaCMS') {
                array_push($packages, strtolower($package));
            }
        }

        return $packages;
    }

    /**
     * Returns the package service provider if exists.
     *
     * @param string $package
     */
    public static function provider($package)
    {
        $location = __DIR__.'/../../'.$package.'/src';

        $files = is_dir($location) ? scandir($location) : [];

        foreach ($files as $file) {
            if (strpos($file, 'ServiceProvider') !== false) {
                return str_replace('.php', '', $file);
            }
        }

        return false;
    }

    /**
     * Returns the if the package is installed.
     *
     * @param string $package
     */
    public static function installed($package)
    {
        return in_array($package, static::all());
    }

    /**
     * Returns the package menu if exists.
     *
     * @param string $package
     */
    public static function menu($package)
    {
        $dir = __DIR__.'/../../'.ucfirst($package).'/src';
        $files = is_dir($dir) ? scandir($dir) : [];
        foreach ($files as $file) {
            if ($file == 'Menu.json') {
                $file_r = file_get_contents($dir.'/'.$file);

                return json_decode($file_r, true);
            }
        }

        return [];
    }

    /**
     * Gets all packages and orders them by preference.
     *
     * @return array
     */
    public static function all()
    {
        $preference = collect(['profile', 'users', 'roles', 'permissions']);

        collect(static::get())->each(function ($package) use ($preference) {
            if (!$preference->contains($package)) {
                $preference->push($package);
            }
        });

        return $preference->toArray();
    }
}