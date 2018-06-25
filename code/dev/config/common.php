<?php

define('APP_ENV', getenv('APP_ENV'));
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('DEV_LANGUAGE', 1);
define('DEV_EMAIL', 'email@localhost.local');
define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../../..');

$config = [
    'staticMap' => include 'other/static.php'
];

switch (APP_ENV) {
    case ENV_DEV:
        return array_replace($config, include 'dev.php');
    default:
        return array_replace($config, include 'prod.php');
}
