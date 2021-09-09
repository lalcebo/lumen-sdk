<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/16/21 4:01 PM.
 */

declare(strict_types=1);

use Lalcebo\Lumen\Support\Arr;

if (!function_exists('route_param')) {
    /**
     * Get a given parameter from the route.
     *
     * @param string $param
     * @param null   $default
     *
     * @return array|ArrayAccess|mixed
     */
    function route_param(string $param, $default = null)
    {
        $route = app('request')->route();

        return Arr::get($route[2] ?? [], $param, $default);
    }
}
