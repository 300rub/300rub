<?php

define('APP_ENV', getenv('APP_ENV'));
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../../..');

switch (APP_ENV) {
    case ENV_DEV:
        return include 'dev.php';
    case ENV_PROD:
        return include 'prod.php';
    default:
        throw new Exception(sprintf('Undefined env: [%s]', APP_ENV));
}
