<?php

define("APP_ENV", getenv('APP_ENV'));
define("ENV_DEV", "dev");
define("ENV_PROD", "prod");
define("ENV_TEST", "test");
define("DEV_HOST", "localhost");
define("DEV_LANGUAGE", 1);
define("DEV_EMAIL", "email@localhost.local");

$config = [

];

switch (APP_ENV) {
    case ENV_TEST:
        $config = require "test.php";
        $config = array_replace($config, require "test.php");
        break;
    default:
        $config = require "dev.php";
        $config = array_replace($config, require "dev.php");
        break;
}

$config["staticMap"] = require "static.php";

return $config;