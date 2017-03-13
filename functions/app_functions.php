<?php

if( ! function_exists('app') ) {
    function app($name = null) {
        $app = \Bootstrap\Application::getInstance();
        return $name ? $app->resolve($name) : $app;
    }
}

if (!function_exists('config')) {
    /**
     * @param $name
     * @param null $value
     * @return mixed
     */
    function config($name, $default = null)
    {
        $value = app('config')->get($name);
        return $value ? $value: ($default? $default: $value);
    }
}

if( ! function_exists('array_get') ) {
    function array_get($array, $key, $default = null) {
        $explode = explode('.', $key);
        foreach($explode as $k) {
            if(isset($array[$k])) {
                $array = $array[$k];
            } else {
                $array = $default;
            }
        }
        return $array;
    }
}