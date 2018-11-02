<?php

return [
    'host'      => 'ss.local',
    'domains' => [
        [
            'siteId' => 1,
            'name'   => 'dev1.local',
            'isMain' => true,
        ],
        [
            'siteId' => 1,
            'name'   => 'dev2.local',
            'isMain' => false,
        ],
    ],
    'db'        => [
        'root' => [
            '127.0.0.1' => [
                'user'     => 'root',
                'password' => 'root',
            ]
        ],
        'dev'  => [
            'host'     => '127.0.0.1',
            'user'     => 'devUser',
            'password' => 'devPassword',
            'name'     => 'dev',
        ],
        'phpunit'  => [
            'host'     => '127.0.0.1',
            'user'     => 'phpunitUser',
            'password' => 'phpunitPassword',
            'name'     => 'phpunit',
        ],
        'selenium' => [
            'host'     => '127.0.0.1',
            'user'     => 'seleniumUser',
            'password' => 'seleniumPassword',
            'name'     => 'selenium',
        ],
        'system' => [
            'host'     => '127.0.0.1',
            'user'     => 'systemUser',
            'password' => 'systemPassword',
            'name'     => 'system',
        ],
        'help'  => [
            'host'     => '127.0.0.1',
            'user'     => 'helpUser',
            'password' => 'helpPassword',
            'name'     => 'help',
        ],
        'source'  => [
            'host'     => '127.0.0.1',
            'user'     => 'sourceUser',
            'password' => 'sourcePassword',
            'name'     => 'source',
        ],
    ],
    'memcached' => [
        'host'       => 'localhost',
        'port'       => 11211,
        'expiration' => 1500,
    ],
    'file' => [
        'pathMask' => FILES_ROOT . '/upload/%s/%s',
        'urlMask'  => 'http://%s/upload/%s/%s'
    ],
    'email' => [
        'host'        => 'smtp.gmail.com',
        'username'    => 'ss.test.dev.local',
        'password'    => 'mypasS77',
        'smtpSecure'  => '587',
        'port'        => '465',
        'fromAddress' => 'ss.test.dev.local@gmail.com',
        'fromName'    => 'SS test dev',
    ],
    'superPassword' => 'mypasS77'
];
