<?php

use ss\application\App;
use ss\application\components\Language;

$config = App::getInstance()->getConfig();

return [
    1 => [
        'name'       => 'dev',
        'dbHost'     => $config->getValue(['db', 'dev', 'host']),
        'dbUser'     => $config->getValue(['db', 'dev', 'user']),
        'dbPassword' => $config->getValue(['db', 'dev', 'password']),
        'dbName'     => $config->getValue(['db', 'dev', 'name']),
        'language'   => Language::LANGUAGE_EN_ID,
        'email'      => 'email@ss.local',
    ],
    2 => [
        'name'       => 'phpunit',
        'dbHost'     => $config->getValue(['db', 'phpunit', 'host']),
        'dbUser'     => $config->getValue(['db', 'phpunit', 'user']),
        'dbPassword' => $config->getValue(['db', 'phpunit', 'password']),
        'dbName'     => $config->getValue(['db', 'phpunit', 'name']),
        'language'   => Language::LANGUAGE_EN_ID,
        'email'      => 'email@ss.local',
    ],
    3 => [
        'name'       => 'selenium',
        'dbHost'     => $config->getValue(['db', 'selenium', 'host']),
        'dbUser'     => $config->getValue(['db', 'selenium', 'user']),
        'dbPassword' => $config->getValue(['db', 'selenium', 'password']),
        'dbName'     => $config->getValue(['db', 'selenium', 'name']),
        'language'   => Language::LANGUAGE_EN_ID,
        'email'      => 'email@ss.local',
    ],
    4 => [
        'name'       => 'source',
        'dbHost'     => $config->getValue(['db', 'source', 'host']),
        'dbUser'     => $config->getValue(['db', 'source', 'user']),
        'dbPassword' => $config->getValue(['db', 'source', 'password']),
        'dbName'     => $config->getValue(['db', 'source', 'name']),
        'language'   => Language::LANGUAGE_EN_ID,
        'email'      => 'email@ss.local',
    ],
];
