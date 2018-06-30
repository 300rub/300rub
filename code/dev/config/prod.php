<?php

return [
    'host'      => 'ss.local',
    'db'        => [
        'dev'  => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'dev',
        ],
        'phpunit' => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'phpunit',
        ],
        'selenium' => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'selenium',
        ],
        'system' => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'system',
        ],
        'help'  => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'help',
        ],
    ],
    'memcached' => [
        'host' => 'localhost',
        'port' => 11211,
    ],
    'file' => [
        'pathMask' => __DIR__ . '/../public/upload/%s/%s',
        'urlMask'  => 'http://%s/upload/%s/%s'
    ]
];
