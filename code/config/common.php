<?php

define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('ENV_DEV_PROD', 'dev_prod');

define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../..');

switch (getenv('APP_ENV')) {
    case ENV_DEV:
        define('APP_ENV', ENV_DEV);
        return include 'dev.php';
    case ENV_PROD:
        define('APP_ENV', ENV_PROD);
        return include 'prod.php';
    case ENV_DEV_PROD:
        define('APP_ENV', ENV_PROD);
        return include 'dev.php';
    default:
        throw new Exception(sprintf('Undefined env: [%s]', APP_ENV));
}
