<?php

namespace testS\tests\unit\models;

use testS\models\RecordModel;

/**
 * Tests for the model RecordModel
 *
 * @package testS\tests\unit\models
 */
class RecordModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return RecordModel
     */
    protected function getNewModel()
    {
        return new RecordModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "coverImageModel"     => [
                        "designBlockModel"       => [
                            "marginTop" => 0,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 0
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 0
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "imagesImageModel"    => [
                        "designBlockModel"       => [
                            "marginTop" => 0,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 0
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 0
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "textTextModel"        => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "designRecordsModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop" => 0
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop" => 0
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 0
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 0
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop" => 0
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 0
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop" => 0
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 0
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop" => 0
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 0
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 0
                        ],
                        "shortCardViewType"                       => 0,
                        "fullCardImagesPosition"                  => 0,
                        "fullCardDatePosition"                    => 0,
                    ],
                    "hasCover"             => false,
                    "hasImages"            => false,
                    "hasCoverZoom"         => false,
                    "hasDescription"       => false,
                    "useAutoload"          => false,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        return [
            "correct1" => [
                [
                    "coverImageModel"     => [
                        "designBlockModel"       => [
                            "marginTop" => 10,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 10
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 10
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => true,
                            "playSpeed"                   => 1,
                            "navigationAlignment"         => 1,
                            "descriptionAlignment"        => 1,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 1,
                            "descriptionAlignment" => 1,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "alignment"                 => 1
                        ],
                        "type"                   => 1,
                        "autoCropType"           => 1,
                        "cropWidth"              => 1,
                        "cropHeight"             => 1,
                        "cropX"                  => 1,
                        "cropY"                  => 1,
                        "thumbAutoCropType"      => 1,
                        "thumbCropX"             => 1,
                        "thumbCropY"             => 1,
                        "useAlbums"              => true,
                    ],
                    "imagesImageModel"    => [
                        "designBlockModel"       => [
                            "marginTop" => 10,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 10
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 10
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => true,
                            "playSpeed"                   => 1,
                            "navigationAlignment"         => 1,
                            "descriptionAlignment"        => 1,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "hasScroll"            => true,
                            "thumbsAlignment"      => 1,
                            "descriptionAlignment" => 1,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 1
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 1
                            ],
                            "alignment"                 => 1
                        ],
                        "type"                   => 1,
                        "autoCropType"           => 1,
                        "cropWidth"              => 1,
                        "cropHeight"             => 1,
                        "cropX"                  => 1,
                        "cropY"                  => 1,
                        "thumbAutoCropType"      => 1,
                        "thumbCropX"             => 1,
                        "thumbCropY"             => 1,
                        "useAlbums"              => true,
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "textTextModel"        => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designRecordsModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop" => 10
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop" => 10
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 10
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop" => 10
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 10
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 10
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop" => 10
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 10
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 10
                        ],
                        "shortCardViewType"                       => 1,
                        "fullCardImagesPosition"                  => 1,
                        "fullCardDatePosition"                    => 1,
                    ],
                    "hasCover"             => true,
                    "hasImages"            => true,
                    "hasCoverZoom"         => true,
                    "hasDescription"       => true,
                    "useAutoload"          => true,
                    "shortCardDateType"    => 1,
                    "fullCardDateType"     => 1,
                ],
                [
                    "coverImageModel"     => [
                        "designBlockModel"       => [
                            "marginTop" => 10,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 10
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 10
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => true,
                            "playSpeed"                   => 1,
                            "navigationAlignment"         => 1,
                            "descriptionAlignment"        => 1,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 1,
                            "descriptionAlignment" => 1,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "alignment"                 => 1
                        ],
                        "type"                   => 1,
                        "autoCropType"           => 1,
                        "cropWidth"              => 1,
                        "cropHeight"             => 1,
                        "cropX"                  => 1,
                        "cropY"                  => 1,
                        "thumbAutoCropType"      => 1,
                        "thumbCropX"             => 1,
                        "thumbCropY"             => 1,
                        "useAlbums"              => true,
                    ],
                    "imagesImageModel"    => [
                        "designBlockModel"       => [
                            "marginTop" => 10,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 10
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 10
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => true,
                            "playSpeed"                   => 1,
                            "navigationAlignment"         => 1,
                            "descriptionAlignment"        => 1,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 10
                            ],
                            "hasScroll"            => true,
                            "thumbsAlignment"      => 1,
                            "descriptionAlignment" => 1,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 1
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 1
                            ],
                            "alignment"                 => 1
                        ],
                        "type"                   => 1,
                        "autoCropType"           => 1,
                        "cropWidth"              => 1,
                        "cropHeight"             => 1,
                        "cropX"                  => 1,
                        "cropY"                  => 1,
                        "thumbAutoCropType"      => 1,
                        "thumbCropX"             => 1,
                        "thumbCropY"             => 1,
                        "useAlbums"              => true,
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "textTextModel"        => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designRecordsModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop" => 10
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop" => 10
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 10
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop" => 10
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 10
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 10
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop" => 10
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 10
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 10
                        ],
                        "shortCardViewType"                       => 1,
                        "fullCardImagesPosition"                  => 1,
                        "fullCardDatePosition"                    => 1,
                    ],
                    "hasCover"             => true,
                    "hasImages"            => true,
                    "hasCoverZoom"         => true,
                    "hasDescription"       => true,
                    "useAutoload"          => true,
                    "shortCardDateType"    => 1,
                    "fullCardDateType"     => 1,
                ],
                [
                    "coverImageModel"     => [
                        "designBlockModel"       => [
                            "marginTop" => 30,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 30
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 30
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "hasScroll"            => true,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "imagesImageModel"    => [
                        "designBlockModel"       => [
                            "marginTop" => 30,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 30
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 30
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop" => 30
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "textTextModel"        => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop" => 30
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "designRecordsModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop" => 30
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop" => 30
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop" => 30
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 30
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 30
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop" => 30
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 30
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop" => 30
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop" => 30
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 30
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop" => 30
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 30
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 30
                        ],
                        "shortCardViewType"                       => 0,
                        "fullCardImagesPosition"                  => 0,
                        "fullCardDatePosition"                    => 0,
                    ],
                    "hasCover"             => false,
                    "hasImages"            => false,
                    "hasCoverZoom"         => false,
                    "hasDescription"       => false,
                    "useAutoload"          => false,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                ],
                [
                    "coverImageModel"     => [
                        "designBlockModel"       => [
                            "marginTop" => 30,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 30
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 30
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "hasScroll"            => true,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "imagesImageModel"    => [
                        "designBlockModel"       => [
                            "marginTop" => 30,
                        ],
                        "designImageSliderModel" => [
                            "containerDesignBlockModel"   => [
                                "marginTop" => 30
                            ],
                            "navigationDesignBlockModel"  => [
                                "marginTop" => 30
                            ],
                            "descriptionDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "effect"                      => 0,
                            "hasAutoPlay"                 => false,
                            "playSpeed"                   => 0,
                            "navigationAlignment"         => 0,
                            "descriptionAlignment"        => 0,
                        ],
                        "designImageZoomModel"   => [
                            "designBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "hasScroll"            => false,
                            "thumbsAlignment"      => 0,
                            "descriptionAlignment" => 0,
                            "effect"               => 0,
                        ],
                        "designImageSimpleModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "imageDesignBlockModel"     => [
                                "marginTop" => 30
                            ],
                            "alignment"                 => 0
                        ],
                        "type"                   => 0,
                        "autoCropType"           => 0,
                        "cropWidth"              => 0,
                        "cropHeight"             => 0,
                        "cropX"                  => 0,
                        "cropY"                  => 0,
                        "thumbAutoCropType"      => 0,
                        "thumbCropX"             => 0,
                        "thumbCropY"             => 0,
                        "useAlbums"              => false,
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop" => 30
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "textTextModel"        => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop" => 30
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "designRecordsModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop" => 30
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop" => 30
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop" => 30
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 30
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 30
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop" => 30
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 30
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop" => 30
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop" => 30
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 30
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop" => 30
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 30
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 30
                        ],
                        "shortCardViewType"                       => 0,
                        "fullCardImagesPosition"                  => 0,
                        "fullCardDatePosition"                    => 0,
                    ],
                    "hasCover"             => false,
                    "hasImages"            => false,
                    "hasCoverZoom"         => false,
                    "hasDescription"       => false,
                    "useAutoload"          => false,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                ]
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [
            "incorrect1" => [
                [
                    "coverImageModel"     => "incorrect",
                    "imagesImageModel"    => "incorrect",
                    "descriptionTextModel" => "incorrect",
                    "textTextModel"        => "incorrect",
                    "designRecordsModel"   => "incorrect",
                    "hasCover"          => "incorrect",
                    "hasImages"         => "incorrect",
                    "hasCoverZoom"      => "incorrect",
                    "hasDescription"    => "incorrect",
                    "useAutoload"       => "incorrect",
                    "shortCardDateType" => "incorrect",
                    "fullCardDateType"  => "incorrect",
                ],
                [
                    "hasCover"             => false,
                    "hasImages"            => false,
                    "hasCoverZoom"         => false,
                    "hasDescription"       => false,
                    "useAutoload"          => false,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                ],
                [
                    "hasCover"             => 999,
                    "hasImages"            => 999,
                    "hasCoverZoom"         => 999,
                    "hasDescription"       => 999,
                    "useAutoload"          => 999,
                    "shortCardDateType"    => 999,
                    "fullCardDateType"     => 999,
                ],
                [
                    "hasCover"             => true,
                    "hasImages"            => true,
                    "hasCoverZoom"         => true,
                    "hasDescription"       => true,
                    "useAutoload"          => true,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "coverImageModel"     => [
                    "designBlockModel"       => [
                        "marginTop" => 10,
                    ],
                    "designImageSliderModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "navigationDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "descriptionDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "effect"                      => 0,
                        "hasAutoPlay"                 => true,
                        "playSpeed"                   => 1,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "hasScroll"            => false,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 1,
                    "cropHeight"             => 1,
                    "cropX"                  => 1,
                    "cropY"                  => 1,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 1,
                    "thumbCropY"             => 1,
                    "useAlbums"              => true,
                ],
                "imagesImageModel"    => [
                    "designBlockModel"       => [
                        "marginTop" => 10,
                    ],
                    "designImageSliderModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "navigationDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "descriptionDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "effect"                      => 0,
                        "hasAutoPlay"                 => true,
                        "playSpeed"                   => 1,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "hasScroll"            => true,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 1
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 1
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 1,
                    "cropHeight"             => 1,
                    "cropX"                  => 1,
                    "cropY"                  => 1,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 1,
                    "thumbCropY"             => 1,
                    "useAlbums"              => true,
                ],
                "descriptionTextModel" => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "textTextModel"        => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designRecordsModel"   => [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop" => 10
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop" => 10
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop" => 10
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop" => 10
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop" => 10
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => 10
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1,
                ],
                "hasCover"             => true,
                "hasImages"            => true,
                "hasCoverZoom"         => true,
                "hasDescription"       => true,
                "useAutoload"          => true,
                "shortCardDateType"    => 1,
                "fullCardDateType"     => 1,
            ],
            [
                "coverImageModel"     => [
                    "designBlockModel"       => [
                        "marginTop" => 10,
                    ],
                    "designImageSliderModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "navigationDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "descriptionDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "effect"                      => 0,
                        "hasAutoPlay"                 => true,
                        "playSpeed"                   => 1,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "hasScroll"            => false,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 1,
                    "cropHeight"             => 1,
                    "cropX"                  => 1,
                    "cropY"                  => 1,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 1,
                    "thumbCropY"             => 1,
                    "useAlbums"              => true,
                ],
                "imagesImageModel"    => [
                    "designBlockModel"       => [
                        "marginTop" => 10,
                    ],
                    "designImageSliderModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "navigationDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "descriptionDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "effect"                      => 0,
                        "hasAutoPlay"                 => true,
                        "playSpeed"                   => 1,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 10
                        ],
                        "hasScroll"            => true,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 1
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 1
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 1,
                    "cropHeight"             => 1,
                    "cropX"                  => 1,
                    "cropY"                  => 1,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 1,
                    "thumbCropY"             => 1,
                    "useAlbums"              => true,
                ],
                "descriptionTextModel" => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "textTextModel"        => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designRecordsModel"   => [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop" => 10
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop" => 10
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop" => 10
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop" => 10
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop" => 10
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => 10
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1,
                ],
                "hasCover"             => true,
                "hasImages"            => true,
                "hasCoverZoom"         => true,
                "hasDescription"       => true,
                "useAutoload"          => true,
                "shortCardDateType"    => 1,
                "fullCardDateType"     => 1,
            ]
        );
    }
}