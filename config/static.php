<?php

return [
    'common' => [
        'libs' => [
            'css' => [
                'fonts/OpenSans/font',
                'lib/fa/css/font-awesome.min',
                'lib/hover-min',
                'lib/jquery.fancybox.min',
            ],
            'js'  => [
                'lib/jquery.min',
                'lib/md5.min',
                'lib/jquery.fancybox.min',
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
            'window/users/Login'
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
            'panel/design/block/Margin',
            'panel/design/block/Padding',
            'panel/design/block/Background',
            'panel/design/block/Border',
            'panel/design/block/Editor',
            'panel/design/text/Align',
            'panel/design/text/Bold',
            'panel/design/text/Color',
            'panel/design/text/Family',
            'panel/design/text/Italic',
            'panel/design/text/Size',
            'panel/design/text/LineHeight',
            'panel/design/text/Decoration',
            'panel/design/text/LetterSpacing',
            'panel/design/text/Transform',
            'panel/design/text/Hover',
            'panel/design/text/Editor',
            'window/users/Form',
            'window/users/List',
            'window/users/Sessions',
        ],
        'compiledCss' => 'admin',
        'compiledJs' => 'admin',
    ],
];
