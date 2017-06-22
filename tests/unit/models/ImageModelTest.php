<?php

namespace testS\tests\unit\models;

use testS\models\ImageModel;

/**
 * Tests for the model ImageModel
 *
 * @package testS\tests\unit\models
 */
class ImageModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return ImageModel
     */
    protected function getNewModel()
    {
        return new ImageModel();
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
                        "designTextModel"           => [
                            "size" => 0
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
                ]
            ],
            "empty2" => [
                [
                    "designBlockModel"       => "",
                    "designImageSliderModel" => "",
                    "designImageZoomModel"   => "",
                    "designImageSimpleModel" => "",
                    "type"                   => "",
                    "autoCropType"           => "",
                    "cropWidth"              => "",
                    "cropHeight"             => "",
                    "cropX"                  => "",
                    "cropY"                  => "",
                    "thumbAutoCropType"      => "",
                    "thumbCropX"             => "",
                    "thumbCropY"             => "",
                    "useAlbums"              => "",
                ],
                [
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
                        "designTextModel"           => [
                            "size" => 0
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
                ]
            ],
            "empty3" => [
                [
                    "designBlockModel"       => [
                        "marginTop" => "",
                    ],
                    "designImageSliderModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => ""
                        ],
                        "descriptionAlignment"      => "",
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel" => [
                            "marginTop" => ""
                        ],
                        "hasScroll"        => ""
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => ""
                        ],
                        "alignment"                 => ""
                    ],
                ],
                [
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
                        "designTextModel"           => [
                            "size" => 0
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
                ]
            ]
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
                        "playSpeed"                   => 10,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "hasScroll"            => true,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 30
                        ],
                        "designTextModel"           => [
                            "size" => 40
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 10,
                    "cropHeight"             => 20,
                    "cropX"                  => 30,
                    "cropY"                  => 40,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 20,
                    "thumbCropY"             => 30,
                    "useAlbums"              => true,
                ],
                [
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
                        "playSpeed"                   => 10,
                        "navigationAlignment"         => 1,
                        "descriptionAlignment"        => 1,
                    ],
                    "designImageZoomModel"   => [
                        "designBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "hasScroll"            => true,
                        "thumbsAlignment"      => 1,
                        "descriptionAlignment" => 1,
                        "effect"               => 0,
                    ],
                    "designImageSimpleModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "imageDesignBlockModel"     => [
                            "marginTop" => 30
                        ],
                        "designTextModel"           => [
                            "size" => 40
                        ],
                        "alignment"                 => 1
                    ],
                    "type"                   => 1,
                    "autoCropType"           => 1,
                    "cropWidth"              => 10,
                    "cropHeight"             => 20,
                    "cropX"                  => 30,
                    "cropY"                  => 40,
                    "thumbAutoCropType"      => 1,
                    "thumbCropX"             => 20,
                    "thumbCropY"             => 30,
                    "useAlbums"              => true,
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
        $this->markTestSkipped();
        return [];
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
                    "playSpeed"                   => 10,
                    "navigationAlignment"         => 1,
                    "descriptionAlignment"        => 1,
                ],
                "designImageZoomModel"   => [
                    "designBlockModel"     => [
                        "marginTop" => 20
                    ],
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 1,
                    "descriptionAlignment" => 1,
                    "effect"               => 0,
                ],
                "designImageSimpleModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop" => 20
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 30
                    ],
                    "designTextModel"           => [
                        "size" => 40
                    ],
                    "alignment"                 => 1
                ],
                "type"                   => 1,
                "autoCropType"           => 1,
                "cropWidth"              => 10,
                "cropHeight"             => 20,
                "cropX"                  => 30,
                "cropY"                  => 40,
                "thumbAutoCropType"      => 1,
                "thumbCropX"             => 20,
                "thumbCropY"             => 30,
                "useAlbums"              => true,
            ],
            [
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
                    "playSpeed"                   => 10,
                    "navigationAlignment"         => 1,
                    "descriptionAlignment"        => 1,
                ],
                "designImageZoomModel"   => [
                    "designBlockModel"     => [
                        "marginTop" => 20
                    ],
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 1,
                    "descriptionAlignment" => 1,
                    "effect"               => 0,
                ],
                "designImageSimpleModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop" => 20
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 30
                    ],
                    "designTextModel"           => [
                        "size" => 40
                    ],
                    "alignment"                 => 1
                ],
                "type"                   => 1,
                "autoCropType"           => 1,
                "cropWidth"              => 10,
                "cropHeight"             => 20,
                "cropX"                  => 30,
                "cropY"                  => 40,
                "thumbAutoCropType"      => 1,
                "thumbCropX"             => 20,
                "thumbCropY"             => 30,
                "useAlbums"              => true,
            ]
        );
    }
}