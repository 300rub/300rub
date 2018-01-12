<?php

return [
    'common' => [
        'libs' => [
            'css' => [
                'fonts/OpenSans/font',
                'lib/fa/css/font-awesome.min',
                'lib/hover-min',
            ],
            'js'  => [
                'lib/jquery.min',
                'lib/md5.min',
            ]
        ],
        'less' => 'common',
        'js'   => [
            'TestS',
            'Validator',
            'Template',
            'Ajax',
            'form/Form',
            'form/Text',
            'form/Hidden',
            'form/Password',
            'form/Checkbox',
            'form/CheckboxButton',
            'form/CheckboxOnOff',
            'Window',
            'window/Login',
            'Login',
        ],
        'compiledCss' => 'common',
        'compiledJs' => 'common',
    ],
    'admin'  => [
        'libs' => [
            'css' => [
                'lib/colorpicker/jquery.colorpicker',
            ],
            'js'  => [
                'lib/jquery-ui.min',
                'lib/jquery.colorpicker',
            ]
        ],
        'less' => 'admin',
        'js'   => [
            'Library',
            'Accordion',
            'UserButtons',
            'Panel',
            'panel/Settings',
            'panel/Block',
            'panel/Block.Text',
            'panel/Block.Text.Settings',
            'panel/design/Design',
            'panel/design/Design.Block',
            'panel/design/block/Margin',
            'panel/design/block/Padding',
            'panel/design/Design.Text',
            'window/Users',
            'window/Users.Sessions',
            'window/Users.Form',
        ],
        'compiledCss' => 'admin',
        'compiledJs' => 'admin',
    ],
];
