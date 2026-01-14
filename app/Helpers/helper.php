<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('hasAnyPermissions')) {

    function hasAnyPermissions($permission)
    {
        if(auth()->user()->role_id == 1)
        {
            return true;
        }
        $guard=getCurrentGuard();
        return auth($guard)->user()->hasPermission($permission);
    }
}

if (!function_exists('getAllRoutesInArray')) {
    function getAllRoutesInArray(): array
    {
        $data = [];
        foreach (Route::getRoutes() as $key => $route) {
            if ($route->getName() && $route->getPrefix() != '' && $route->getPrefix() != '_ignition') {
                $data[$key] = [
                    'name' => $route->getName(),
                    'prefix' => $route->getPrefix(),
                ];
            }
        }
        $arr = array();
        foreach ($data as $key => $item) {
            $arr[$item['prefix']][$key] = $item;
        }
        ksort($arr, SORT_NUMERIC);
        return $arr;
    }
}

if (!function_exists('getCurrentGuard')) {
    function getCurrentGuard():string
    {
        $guards = array_keys(config('auth.guards'));
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
    }
}