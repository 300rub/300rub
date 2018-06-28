<?php

return [
    'host'      => 'ss.local',
    'db'        => [
        'test' => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'test',
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
