<?php

return [
    'common' => [
        'libs' => [
            'css' => [
                'fonts/OpenSans/font',
                'lib/fa/css/fontawesome-all.min',
                'lib/hover-min',
                'lib/jquery.fancybox.min',
            ],
            'js'  => [
                'lib/jquery.min',
                'lib/jquery.fancybox.min',
                'lib/jssor.slider.min',
            ]
        ],
        'less' => 'common',
        'js'   => [
            'Ss',
            'components/Validator',
            'components/Template',
            'components/Error',
            'components/Ajax',
            'components/Autoload',
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
            'forms/Textarea',
            'forms/Link',
            'window/Collection',
            'window/Abstract',
            'window/users/Login',
            'window/users/ResetEmail',
            'window/users/ResetCode',
            'content/block/Update',
            'content/menu/Abstract',
            'content/menu/Horizontal',
        ],
        'compiledCss' => 'common.min',
        'compiledJs' => 'common.min',
    ],
    'admin'  => [
        'libs' => [
            'css' => [
                'lib/colorpicker/jquery.colorpicker',
                'lib/gridstack.min',
            ],
            'js'  => [
                'lib/jquery-ui.min',
                'lib/jquery.colorpicker',
                'lib/underscore-min',
                'lib/gridstack.min',
            ]
        ],
        'less' => 'admin',
        'js'   => [
            'components/Library',
            'components/accordion/Container',
            'components/accordion/Element',
            'system/UserButtons',
            'forms/components/Seo',
            'panel/Abstract',
            'panel/settings/List',
            'panel/settings/CodeList',
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
            'panel/release/ShortInfo',
            'panel/section/List',
            'panel/section/Settings',
            'window/users/Form',
            'window/users/List',
            'window/users/Sessions',
            'window/release/FullInfo',
            'window/settings/Code',
            'window/section/Structure',
        ],
        'compiledCss' => 'admin.min',
        'compiledJs' => 'admin.min',
    ],
];
