<?php

define('APP_ENV', getenv('APP_ENV'));
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../../..');

$config = [
    'staticMap' => include 'other/static.php'
];

switch (APP_ENV) {
    case ENV_DEV:
        return array_replace($config, include 'dev.php');
    case ENV_PROD:
        return array_replace($config, include 'prod.php');
    default:
        throw new Exception(sprintf('Undefined env: [%s]', APP_ENV));
}
