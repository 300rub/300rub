<?php

define('APP_ENV', getenv('APP_ENV'));
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('ENV_PRE_PROD', 'preProd');
define('DEV_HOST', 'localhost');
define('DEV_LANGUAGE', 1);
define('DEV_EMAIL', 'email@localhost.local');

$config = [];

switch (APP_ENV) {
    case ENV_PRE_PROD:
        $config = include 'preProd.php';
        $config = array_replace($config, include 'preProd.php');
        break;
    default:
        $config = include 'dev.php';
        $config = array_replace($config, include 'dev.php');
        break;
}

$config['staticMap'] = include 'static.php';

return $config;
