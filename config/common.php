<?php

define("APP_ENV", getenv('APP_ENV'));
define("ENV_DEV", "dev");
define("ENV_PROD", "prod");
define("ENV_TEST", "test");
define("DEV_HOST", "localhost");
define("DEV_LANGUAGE", 1);
define("DEV_EMAIL", "email@localhost.local");

switch (APP_ENV) {
    case ENV_PROD:
        $config = require "prod.php";
        break;
    case ENV_TEST:
        $config = require "test.php";
        break;
    default:
        $config = require "dev.php";
        break;
}

$config["staticMap"] = require "static.php";

return $config;

// Main settings
return [
    "isDebug"   => true,
    "host"      => "localhost",
    "language"  => 1,
    "db"        => [
        "host"     => "127.0.0.1",
        "user"     => "root",
        "password" => "root",
        "name"     => "testS",
    ],
    "email"     => [
        "address" => "donvasilion@gmail.com",
    ],
    "helpDb"    => [
        "host"     => "localhost",
        "user"     => "root",
        "password" => "",
        "name"     => "help",
    ],
    "ssh"       => [
        "active" => "fileServer001",
        "list"   => [
            "fileServer001" => [
                "host"           => "",
                "port"           => 22,
                "username"       => "",
                "publicKeyPath"  => "",
                "privateKeyPath" => "",
                "passPhrase"     => "",
                "uploadFolder"   => "/var/www/upload"
            ]
        ]
    ],
    "siteId"    => 0,
    "memcached" => [
        "host" => "localhost",
        "port" => 11211
    ]
];