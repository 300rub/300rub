<?php

use ss\models\blocks\image\ImageModel;

return [
    1 => [
        'type' => ImageModel::TYPE_ZOOM
    ],
    2 => [
        'type'                   => ImageModel::TYPE_SLIDER,
        'designImageSliderModel' => [
            'effect'      =>
                'Fade;Rotate away;Rotate Zoom+ in;Zoom VDouble+ in;' .
                'Collapse Stairs;Expand Stairs;Float Right Random;' .
                'Fly Right Random;Dominoes Stripe',
            'hasAutoPlay' => true
        ]
    ],
    3 => [
        'type' => ImageModel::TYPE_SIMPLE
    ],
    4 => [
        'type'      => ImageModel::TYPE_ZOOM,
        'useAlbums' => true,
    ]
];
