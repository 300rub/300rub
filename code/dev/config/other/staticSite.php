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
        'js'   => [
            'Ss',
            'components/Template',
            'components/Ajax',
            'system/App',
            'forms/Abstract',
            'forms/Button',
            'forms/Checkbox',
            'forms/CheckboxButton',
            'forms/CheckboxOnOff',
            'forms/Color',
            'forms/Hidden',
            'forms/Password',
            'forms/RadioButtons',
            'forms/Select',
            'forms/Spinner',
            'forms/Text',
            'window/Collection',
            'window/Abstract',
            'window/site/Create',
        ],
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
