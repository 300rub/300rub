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
        'dev'  => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'dev',
        ],
        'test'  => [
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
        'host'          => 'localhost',
        'port'          => 11211,
        'isIgnoreCache' => true
    ],
    'file' => [
        'pathMask' => __DIR__ . '/../public/upload/%s/%s',
        'urlMask'  => 'http://%s/upload/%s/%s'
    ]
];
