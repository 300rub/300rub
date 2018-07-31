<?php

use ss\models\blocks\menu\MenuModel;

return [
    1 => [
        'designMenuModel' => [
            'firstLevelDesignBlockModel' => [
                'marginTop'                => -1,
                'paddingTop'               => 10,
                'paddingRight'             => 20,
                'paddingBottom'            => 10,
                'paddingLeft'              => 20,
                'borderTopWidth'           => 1,
                'borderRightWidth'         => 1,
                'borderBottomWidth'        => 1,
                'borderLeftWidth'          => 1,
                'borderColor'              => 'rgba(0,255,255,1)',
                'hasBackgroundHover'       => true,
                'backgroundColorFromHover' => 'rgba(0,0,0,0.03)',
            ],
            'firstLevelDesignTextModel' => [
                'size' => 16
            ],
            'firstLevelActiveDesignBlockModel' => [
                'marginTop'                => -1,
                'paddingTop'               => 10,
                'paddingRight'             => 20,
                'paddingBottom'            => 10,
                'paddingLeft'              => 20,
                'borderTopWidth'           => 1,
                'borderRightWidth'         => 1,
                'borderBottomWidth'        => 1,
                'borderLeftWidth'          => 1,
                'borderColor'              => 'rgba(0,255,255,1)',
                'hasBackgroundHover'       => true,
                'backgroundColorFromHover' => 'rgba(0,0,0,0.03)',
            ],
            'firstLevelActiveDesignTextModel' => [
                'size'   => 16,
                'isBold' => true,
            ],
            'secondLevelDesignBlockModel' => [
                'marginTop'                => -1,
                'paddingTop'               => 10,
                'paddingRight'             => 20,
                'paddingBottom'            => 10,
                'paddingLeft'              => 40,
                'borderTopWidth'           => 1,
                'borderRightWidth'         => 1,
                'borderBottomWidth'        => 1,
                'borderLeftWidth'          => 1,
                'borderColor'              => 'rgba(0,255,255,1)',
                'hasBackgroundHover'       => true,
                'backgroundColorFromHover' => 'rgba(0,0,0,0.03)',
            ],
            'secondLevelDesignTextModel' => [
                'size' => 14
            ],
            'secondLevelActiveDesignBlockModel' => [
                'marginTop'                => -1,
                'paddingTop'               => 10,
                'paddingRight'             => 20,
                'paddingBottom'            => 10,
                'paddingLeft'              => 40,
                'borderTopWidth'           => 1,
                'borderRightWidth'         => 1,
                'borderBottomWidth'        => 1,
                'borderLeftWidth'          => 1,
                'borderColor'              => 'rgba(0,255,255,1)',
                'hasBackgroundHover'       => true,
                'backgroundColorFromHover' => 'rgba(0,0,0,0.03)',
            ],
            'secondLevelActiveDesignTextModel' => [
                'size'   => 14,
                'isBold' => true,
            ],
        ]
    ],
    2 => [
        'type'            => MenuModel::TYPE_HORIZONTAL,
        'designMenuModel' => [

        ],
    ],
];
