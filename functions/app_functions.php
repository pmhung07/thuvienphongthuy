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


if( ! function_exists('_debug') ) {
    function _debug($data) {

        echo '<pre style="background: #000; color: #fff; width: 100%; overflow: auto">';
        echo '<div>Your IP: ' . $_SERVER['REMOTE_ADDR'] . '</div>';

        $debug_backtrace = debug_backtrace();
        $debug = array_shift($debug_backtrace);

        echo '<div>File: ' . $debug['file'] . '</div>';
        echo '<div>Line: ' . $debug['line'] . '</div>';

        if(is_array($data) || is_object($data)) {
            print_r($data);
        }
        else {
            var_dump($data);
        }
        echo '</pre>';
    }
}