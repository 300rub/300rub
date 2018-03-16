<?php

use ss\models\blocks\image\ImageModel;

return [
    1 => [
        'type' => ImageModel::TYPE_ZOOM
    ],
    2 => [
        'type' => ImageModel::TYPE_SLIDER
    ],
    3 => [
        'type' => ImageModel::TYPE_SIMPLE
    ],
    4 => [
        'type'      => ImageModel::TYPE_ZOOM,
        'useAlbums' => true,
    ]
];
