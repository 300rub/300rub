<?php

use ss\models\blocks\image\ImageModel;

return [
    1 => [
        'type' => ImageModel::TYPE_ZOOM,
        'designImageZoomModel' => [
            'designBlockModel' => [
                'width'  => 160,
                'height' => 160,
            ]
        ]
    ],
    2 => [
        'type'                   => ImageModel::TYPE_SLIDER,
        'cropWidth'              => 600,
        'cropHeight'             => 200,
        'designImageSliderModel' => [
            'effect'      =>
                'Fade;Rotate away;Rotate Zoom+ in;Zoom VDouble+ in;' .
                'Collapse Stairs;Expand Stairs;Float Right Random;' .
                'Fly Right Random;Dominoes Stripe',
            'hasAutoPlay' => true,
            'arrowDesignTextModel' => [
                'size'  => 40,
                'color' => 'rgba(255,255,255,0.5)',
            ],
            'bulletDesignBlockModel' => [
                'backgroundColorFrom' => 'rgba(255,255,255)',
                'borderTopWidth'      => 1,
                'borderRightWidth'    => 1,
                'borderBottomWidth'   => 1,
                'borderLeftWidth'     => 1,
                'borderStyle'         => 0,
                'borderColor'         => 'rgba(0,0,0)',
            ],
            'bulletActiveDesignBlockModel' => [
                'backgroundColorFrom' => 'rgba(0,0,0)',
                'borderTopWidth'      => 1,
                'borderRightWidth'    => 1,
                'borderBottomWidth'   => 1,
                'borderLeftWidth'     => 1,
                'borderStyle'         => 0,
                'borderColor'         => 'rgba(0,0,0)',
            ],
            'descriptionDesignBlockModel' => [
                'backgroundColorFrom' => 'rgba(0,0,0,0.25)',
            ],
            'descriptionDesignTextModel' => [
                'color' => 'rgba(255,255,255)',
            ],
        ]
    ],
    3 => [
        'type' => ImageModel::TYPE_SIMPLE,
        'designImageSimpleModel' => [
            'containerDesignBlockModel' => [
                'marginBottom' => 20
            ],
            'useDescription' => true,
            'alignment'      => 1,
        ],

    ],
    4 => [
        'type'      => ImageModel::TYPE_ZOOM,
        'useAlbums' => true,
        'designImageAlbumModel' => [
            'imageDesignBlockModel' => [
                'width'  => 170,
                'height' => 170,
            ]
        ]
    ]
];
