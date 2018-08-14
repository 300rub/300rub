<?php

return [
    'common' => [
        'libs' => [
            'css' => [
                'fonts/OpenSans/font',
                'lib/fa/css/fontawesome-all.min',
            ],
            'js'  => [
                'lib/jquery.min',
            ]
        ],
        'less' => 'site/common',
        'js'   => [],
        'compiledCss' => 'site.min',
        'compiledJs' => 'site.min',
    ],
    'admin'  => [
        'libs' => [
            'css' => [],
            'js'  => []
        ],
        'less' => 'site/admin',
        'js'   => [],
        'compiledCss' => 'site-admin.min',
        'compiledJs' => 'site-admin.min',
    ],
];
