<?php

define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');
define('ENV_DEV_PROD', 'dev_prod');

define('CODE_ROOT', __DIR__ . '/..');
define('FILES_ROOT', __DIR__ . '/../..');

switch (getenv('APP_ENV')) {
    case ENV_DEV:
        define('APP_ENV', ENV_DEV);
        return json_decode(file_get_contents(__DIR__ . '/env/dev.json'), true);
    case ENV_DEV_PROD:
        define('APP_ENV', ENV_PROD);
        return json_decode(file_get_contents(__DIR__ . '/env/dev.json'), true);
    default:
        define('APP_ENV', ENV_PROD);
        return json_decode(file_get_contents(__DIR__ . '/env/prod.json'), true);
}
