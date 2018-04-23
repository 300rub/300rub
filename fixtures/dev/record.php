<?php

use ss\models\blocks\record\DesignRecordModel;

return [
    1 => [
        'textTextId' => 1,
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

            'fullCardDatePosition' => DesignRecordModel::FULL_CART_DATE_POSITION_RIGHT
        ]
    ]
];
