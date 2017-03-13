<?php

require_once realpath(dirname(__DIR__)) . '/vendor/autoload.php';

/**
 * Put env
 */
$envFile = realpath(dirname(__DIR__) . '/.env');

$envData = parse_ini_file($envFile);

foreach($envData as $key => $value) {
    putenv("$key=$value");
}

/**
 * Put config
 */
$app = require_once 'app.php';

$app->register('config', function() {
    return new \Bootstrap\Config();
});