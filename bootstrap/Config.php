<?php

namespace Bootstrap;

class Config {

    protected $configs = array();

    public function __construct()
    {
        $configPath = __DIR__ . '../config';
        foreach(glob($configPath . '/*.php') as $file) {
            $config = require($file);
            $configName = str_replace('.php', '', $config);
            $this->configs[$configName] = $config;
        }
    }

    public function get($key, $default = null)
    {
        return array_get($this->configs, $key, $default);
    }
}