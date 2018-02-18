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
            'Ss',
            'components/Validator',
            'components/Template',
            'components/Error',
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
            'window/users/Login',
            'system/Login',
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
            'components/Library',
            'components/accordion/Container',
            'components/accordion/Element',
            'system/UserButtons',
            'panel/Abstract',
            'panel/settings/List',
            'panel/blocks/List',
            'panel/blocks/text/List',
            'panel/blocks/text/Settings',
            'panel/design/AbstractEditor',
            'panel/design/AbstractGroup',
            'panel/design/Editor',
            'panel/design/block/Editor',
            'panel/design/block/Margin',
            'panel/design/block/Padding',
            'panel/design/block/Background',
            'panel/design/block/Border',
            'window/users/Form',
            'window/users/List',
            'window/users/Sessions',
        ],
        'compiledCss' => 'admin',
        'compiledJs' => 'admin',
    ],
];
