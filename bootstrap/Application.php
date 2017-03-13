<?php

namespace Bootstrap;

use Pimple\Container;

class Application {

    private static $instance;

    public function __construct($container = [])
    {
        $this->container = ($container instanceof Container)? $container:new Container($container);
        self::$instance = &$this;
    }

    public static function getInstance()
    {
        return self::$instance?self::$instance:new self;
    }

    public function register($name, $callback)
    {
        $this->container[$name] = $callback;
    }

    public function resolve($name)
    {
        return $this->container[$name];
    }
}