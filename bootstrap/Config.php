<?php

namespace Bootstrap;

class Config {

    protected $configs = array();

    public function __construct()
    {
        $configPath =realpath(dirname(__DIR__)) . '/config';
        foreach(glob($configPath . '/*.php') as $file) {
            $config = require($file);
            $configName = str_replace('.php', '', basename($file));
            $this->configs[$configName] = $config;
        }
    }

    public function get($key, $default = null)
    {
        return array_get($this->configs, $key, $default);
    }
}