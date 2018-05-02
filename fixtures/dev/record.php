<?php

use ss\models\blocks\record\DesignRecordModel;
use ss\models\blocks\record\RecordModel;

return [
    1 => [
        'imagesImageId'     => 5,
        'designRecordModel' => [
            'fullCardTitleDesignBlockModel' => [
                'marginBottom' => 20
            ],
            'fullCardTitleDesignTextModel' => [
                'size' => 24
            ],
            'fullCardDateDesignBlockModel' => [
                'marginLeft' => 20
            ],
            'fullCardDateDesignTextModel' => [
                'color' => 'rgba(123,123,123,1)'
            ],
            'fullCardTextDesignBlockModel' => [
                'marginLeft' => 20
            ],
            'fullCardDatePosition'
                => DesignRecordModel::FULL_CART_DATE_POSITION_RIGHT
        ],
        'hasCover'           => true,
        'hasImages'          => true,
        'hasCoverZoom'       => true,
        'hasDescription'     => true,
        'useAutoload'        => true,
        'pageNavigationSize' => 4,
        'shortCardDateType'  => RecordModel::DATE_TYPE_COMMON,
        'fullCardDateType'   => RecordModel::DATE_TYPE_COMMON,
    ],
    2 => [
        'imagesImageId'     => 6,
        'designRecordModel' => [
            'fullCardTitleDesignBlockModel' => [
                'marginBottom' => 20
            ],
            'fullCardTitleDesignTextModel' => [
                'size' => 24
            ],
            'fullCardDateDesignBlockModel' => [
                'marginLeft' => 20
            ],
            'fullCardDateDesignTextModel' => [
                'color' => 'rgba(123,123,123,1)'
            ],
            'fullCardTextDesignBlockModel' => [
                'marginLeft' => 20
            ],
            'fullCardDatePosition'
            => DesignRecordModel::FULL_CART_DATE_POSITION_RIGHT
        ],
        'hasCover'           => true,
        'hasImages'          => true,
        'hasCoverZoom'       => false,
        'hasDescription'     => false,
        'useAutoload'        => false,
        'pageNavigationSize' => 4,
        'shortCardDateType'  => RecordModel::DATE_TYPE_COMMON,
        'fullCardDateType'   => RecordModel::DATE_TYPE_COMMON,
    ],
];
