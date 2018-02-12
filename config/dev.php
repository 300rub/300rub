<?php

return [
    'host'      => 'ss.local',
    'domains' => [
        [
            'siteId' => 1,
            'name'   => 'site11.local',
            'isMain' => true,
        ],
        [
            'siteId' => 1,
            'name'   => 'site12.local',
            'isMain' => false,
        ],
        [
            'siteId' => 2,
            'name'   => 'site21.local',
            'isMain' => false,
        ],
        [
            'siteId' => 2,
            'name'   => 'site22.local',
            'isMain' => true,
        ],
    ],
    'db'        => [
        'site1'  => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'site1',
        ],
        'site2'  => [
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => 'root',
            'name'     => 'site2',
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
        'port' => 11211
    ],
    'file' => [
        'pathMask' => __DIR__ . '/../public/upload/%s/%s',
        'urlMask'  => 'http://%s/upload/%s/%s'
    ]
];
