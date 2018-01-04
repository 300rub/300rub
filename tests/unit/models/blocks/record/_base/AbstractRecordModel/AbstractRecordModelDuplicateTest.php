<?php

namespace testS\tests\unit\models\blocks\record\_base\AbstractRecordModel;

use testS\models\blocks\record\RecordModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
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
