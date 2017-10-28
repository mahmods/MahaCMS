<?php

namespace MahaCMS\MahaCMS;

use Auth;
use MahaCMS\Users\Models\User;

class Menu
{
    public $name;
    public $items = [];

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function item($item)
    {
        array_push($this->items, $item);

        return $this;
    }

    public static function generate()
    {
        $user = User::findOrFail(Auth::guard('api')->user()->id);
        $m = new self();
        foreach (Packages::all() as $package) {
            $pm = new self();
            $pm->name(ucfirst($package));
            $pma = Packages::menu($package);

            if (array_key_exists('items', $pma)) {
                $pm->items = array_merge($pm->items, static::getPackageMenuItems($pma, $user));
            }

            if (count($pm->items) > 0) {
                $m->item($pm);
            }
        }

        $m->items = array_merge($m->items, static::getCustomMenuItems($user));

        return $m->items;
    }

    public static function getCustomMenuItems($user)
    {
        $menuItems = [];

        if (array_key_exists('menu', config('mahacms'))) {
            foreach (config('mahacms.menu') as $custom_menu) {
                $pm = new self();
                $pm->name(ucfirst($custom_menu['title']));
                $pm->items = array_merge($pm->items, static::getPackageMenuItems($custom_menu, $user));

                if (count($pm->items) > 0) {
                    array_push($menuItems, $pm);
                }
            }
        }

        return $menuItems;
    }

    public static function getPackageMenuItems($menu, $user)
    {
        $packageItems = [];

        foreach ($menu['items'] as $i) {
            $item = new Item();
            $item->text = $i['text'];
            $item->url = $i['link'];

            if (array_key_exists('permission', $i) && !$user->superAdmin()) {
                if (!$user->hasPermission($i['permission'])) {
                    continue;
                }
            }

            array_push($packageItems, $item);
        }

        return $packageItems;
    }
}