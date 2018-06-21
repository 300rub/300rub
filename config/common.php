<?php

define('APP_ENV', getenv('APP_ENV'));
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('DEV_LANGUAGE', 1);
define('DEV_EMAIL', 'email@localhost.local');
define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../../..');

$config = [
    'host'=> 'ss.com',
];

if (APP_ENV === ENV_DEV) {
    $config = include 'dev.php';
    $config = array_replace($config, include 'dev.php');
}

$config['staticMap'] = include 'other/static.php';

return $config;
