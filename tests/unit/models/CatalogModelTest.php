<?php

namespace testS\tests\unit\models;

use testS\models\CatalogModel;

/**
 * Tests for the model CatalogModel
 *
 * @package testS\tests\unit\models
 */
class CatalogModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogModel
     */
    protected function getNewModel()
    {
        return new CatalogModel();
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
                    "imageModel"           => [
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
                    ],
                    "tabModel"             => [
                        "designTabsModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "tabDesignBlockModel"       => [
                                "marginTop" => 0
                            ],
                            "tabDesignTextModel"        => [
                                "size" => 0
                            ],
                            "contentDesignBlockModel"   => [
                                "marginTop" => 0
                            ],
                        ],
                        "textModel"       => [
                            "designTextModel"  => [
                                "size" => 0
                            ],
                            "designBlockModel" => [
                                "marginTop" => 0
                            ],
                            "type"             => 0,
                            "hasEditor"        => false,
                        ],
                        "isShowEmpty"     => false,
                        "isLazyLoad"      => false,
                    ],
                    "fieldModel"           => [
                        "designFieldModel" => [
                            "shortCardContainerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "shortCardLabelDesignBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "shortCardLabelDesignTextModel"      => [
                                "size" => 0
                            ],
                            "shortCardValueDesignBlockModel"     => [
                                "marginTop" => 0
                            ],
                            "shortCardValueDesignTextModel"      => [
                                "size" => 0
                            ],
                            "fullCardContainerDesignBlockModel"  => [
                                "marginTop" => 0
                            ],
                            "fullCardLabelDesignBlockModel"      => [
                                "marginTop" => 0
                            ],
                            "fullCardLabelDesignTextModel"       => [
                                "size" => 0
                            ],
                            "fullCardValueDesignBlockModel"      => [
                                "marginTop" => 0
                            ],
                            "fullCardValueDesignTextModel"       => [
                                "size" => 0
                            ],
                        ]
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
                    "designCatalogModel"   => [
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
                        "shortCardPriceDesignBlockModel"          => [
                            "marginTop" => 0
                        ],
                        "shortCardPriceDesignTextModel"           => [
                            "size" => 0
                        ],
                        "shortCardOldPriceDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "shortCardOldPriceDesignTextModel"        => [
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
                        "shortCardViewType"                       => 0,
                        "fullCardImagesPosition"                  => 0,
                        "fullCardDatePosition"                    => 0
                    ],
                    "hasImages"            => false,
                    "useAutoload"          => false,
                    "pageNavigationSize"   => 0,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                    "hasRelations"         => false,
                    "relationsLabel"       => "",
                    "hasBin"               => false,
                ],
                null,
                null,
                null,
                null,
                [
                    "designCatalogModel_fullCardContainerDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignTextModel",
                    "designCatalogModel_fullCardDateDesignTextModel",
                    "designCatalogModel_fullCardPriceDesignBlockModel",
                    "designCatalogModel_fullCardPriceDesignTextModel",
                    "designCatalogModel_fullCardOldPriceDesignBlockModel",
                    "designCatalogModel_fullCardOldPriceDesignTextModel",
                    "designCatalogModel_fullCardBinButtonDesignBlockModel",
                    "designCatalogModel_fullCardBinButtonDesignTextModel",
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
                    "imageModel"           => [
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
                    "tabModel"             => [
                        "designTabsModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "tabDesignBlockModel"       => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "tabDesignTextModel"        => [
                                "size" => 20
                            ],
                            "contentDesignBlockModel"   => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                        ],
                        "textModel"       => [
                            "designTextModel"  => [
                                "size" => 10
                            ],
                            "designBlockModel" => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "type"             => 1,
                            "hasEditor"        => true,
                        ],
                        "isShowEmpty"     => true,
                        "isLazyLoad"      => true,
                    ],
                    "fieldModel"           => [
                        "designFieldModel" => [
                            "shortCardContainerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "shortCardLabelDesignBlockModel"     => [
                                "marginTop" => 20
                            ],
                            "shortCardLabelDesignTextModel"      => [
                                "size" => 30
                            ],
                            "shortCardValueDesignBlockModel"     => [
                                "marginTop" => 40
                            ],
                        ],
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 20
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designCatalogModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 10
                        ],
                        "shortCardPriceDesignBlockModel"          => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPriceDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardOldPriceDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardOldPriceDesignTextModel"        => [
                            "size" => 10
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 10
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 10
                        ],
                        "fullCardContainerDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "fullCardTitleDesignBlockModel"           => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "fullCardTitleDesignTextModel"            => [
                            "size" => 10
                        ],
                        "fullCardDateDesignTextModel"             => [
                            "size" => 10
                        ],
                        "fullCardPriceDesignBlockModel"           => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "fullCardPriceDesignTextModel"            => [
                            "size" => 10
                        ],
                        "fullCardOldPriceDesignBlockModel"        => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "fullCardOldPriceDesignTextModel"         => [
                            "size" => 10
                        ],
                        "fullCardBinButtonDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "fullCardBinButtonDesignTextModel"        => [
                            "size" => 10
                        ],
                        "shortCardViewType"                       => 1,
                        "fullCardImagesPosition"                  => 1,
                        "fullCardDatePosition"                    => 1
                    ],
                    "hasImages"            => true,
                    "useAutoload"          => true,
                    "pageNavigationSize"   => 10,
                    "shortCardDateType"    => 1,
                    "fullCardDateType"     => 1,
                    "hasRelations"         => true,
                    "relationsLabel"       => "Relations label",
                    "hasBin"               => true,
                ],
                [
                    "imageModel"           => [
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
                    "tabModel"             => [
                        "designTabsModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "tabDesignBlockModel"       => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "tabDesignTextModel"        => [
                                "size" => 20
                            ],
                            "contentDesignBlockModel"   => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                        ],
                        "textModel"       => [
                            "designTextModel"  => [
                                "size" => 10
                            ],
                            "designBlockModel" => [
                                "marginTop"                => 10,
                                "borderBottomWidth"        => 7,
                                "borderColorHover"         => "rgb(0,255,0)",
                                "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                            ],
                            "type"             => 1,
                            "hasEditor"        => true,
                        ],
                        "isShowEmpty"     => true,
                        "isLazyLoad"      => true,
                    ],
                    "fieldModel"           => [
                        "designFieldModel" => [
                            "shortCardContainerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "shortCardLabelDesignBlockModel"     => [
                                "marginTop" => 20
                            ],
                            "shortCardLabelDesignTextModel"      => [
                                "size" => 30
                            ],
                            "shortCardValueDesignBlockModel"     => [
                                "marginTop" => 40
                            ],
                        ],
                    ],
                    "descriptionTextModel" => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 20
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designCatalogModel"   => [
                        "shortCardContainerDesignBlockModel"      => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardInstanceDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardTitleDesignBlockModel"          => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardTitleDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardDateDesignTextModel"            => [
                            "size" => 10
                        ],
                        "shortCardPriceDesignBlockModel"          => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPriceDesignTextModel"           => [
                            "size" => 10
                        ],
                        "shortCardOldPriceDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardOldPriceDesignTextModel"        => [
                            "size" => 10
                        ],
                        "shortCardDescriptionDesignBlockModel"    => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardDescriptionDesignTextModel"     => [
                            "size" => 10
                        ],
                        "shortCardPaginationDesignBlockModel"     => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPaginationItemDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "shortCardPaginationItemDesignTextModel"  => [
                            "size" => 10
                        ],
                        "shortCardViewType"                       => 1,
                        "fullCardImagesPosition"                  => 1,
                        "fullCardDatePosition"                    => 1
                    ],
                    "hasImages"            => true,
                    "useAutoload"          => true,
                    "pageNavigationSize"   => 10,
                    "shortCardDateType"    => 1,
                    "fullCardDateType"     => 1,
                    "hasRelations"         => true,
                    "relationsLabel"       => "Relations label",
                    "hasBin"               => true,
                ],
                null,
                null,
                null,
                null,
                [
                    "designCatalogModel_fullCardContainerDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignTextModel",
                    "designCatalogModel_fullCardDateDesignTextModel",
                    "designCatalogModel_fullCardPriceDesignBlockModel",
                    "designCatalogModel_fullCardPriceDesignTextModel",
                    "designCatalogModel_fullCardOldPriceDesignBlockModel",
                    "designCatalogModel_fullCardOldPriceDesignTextModel",
                    "designCatalogModel_fullCardBinButtonDesignBlockModel",
                    "designCatalogModel_fullCardBinButtonDesignTextModel",
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
                    "hasImages"            => "incorrect",
                    "useAutoload"          => "incorrect",
                    "pageNavigationSize"   => "incorrect",
                    "shortCardDateType"    => "incorrect",
                    "fullCardDateType"     => "incorrect",
                    "hasRelations"         => "incorrect",
                    "relationsLabel"       => ["incorrect"],
                    "hasBin"               => "incorrect",
                ],
                [
                    "hasImages"            => false,
                    "useAutoload"          => false,
                    "pageNavigationSize"   => 0,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                    "hasRelations"         => false,
                    "relationsLabel"       => "",
                    "hasBin"               => false,
                ],
                [
                    "hasImages"            => 999,
                    "useAutoload"          => 999,
                    "pageNavigationSize"   => true,
                    "shortCardDateType"    => 999,
                    "fullCardDateType"     => 999,
                    "hasRelations"         => 999,
                    "relationsLabel"       => 999,
                    "hasBin"               => 999,
                ],
                [
                    "hasImages"            => true,
                    "useAutoload"          => true,
                    "pageNavigationSize"   => 1,
                    "shortCardDateType"    => 0,
                    "fullCardDateType"     => 0,
                    "hasRelations"         => true,
                    "relationsLabel"       => "999",
                    "hasBin"               => true,
                ],
                null,
                null,
                [
                    "designCatalogModel_fullCardContainerDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignBlockModel",
                    "designCatalogModel_fullCardTitleDesignTextModel",
                    "designCatalogModel_fullCardDateDesignTextModel",
                    "designCatalogModel_fullCardPriceDesignBlockModel",
                    "designCatalogModel_fullCardPriceDesignTextModel",
                    "designCatalogModel_fullCardOldPriceDesignBlockModel",
                    "designCatalogModel_fullCardOldPriceDesignTextModel",
                    "designCatalogModel_fullCardBinButtonDesignBlockModel",
                    "designCatalogModel_fullCardBinButtonDesignTextModel",
                ]
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
                "imageModel"           => [
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
                "tabModel"             => [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 20
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "type"             => 1,
                        "hasEditor"        => true,
                    ],
                    "isShowEmpty"     => true,
                    "isLazyLoad"      => true,
                ],
                "fieldModel"           => [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 30
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 40
                        ],
                    ],
                ],
                "descriptionTextModel" => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 20
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designCatalogModel"   => [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardPriceDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPriceDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardOldPriceDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardOldPriceDesignTextModel"        => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 10
                    ],
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 10
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1
                ],
                "hasImages"            => true,
                "useAutoload"          => true,
                "pageNavigationSize"   => 10,
                "shortCardDateType"    => 1,
                "fullCardDateType"     => 1,
                "hasRelations"         => true,
                "relationsLabel"       => "Relations label",
                "hasBin"               => true,
            ],
            [
                "imageModel"           => [
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
                "tabModel"             => [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 20
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "type"             => 1,
                        "hasEditor"        => true,
                    ],
                    "isShowEmpty"     => true,
                    "isLazyLoad"      => true,
                ],
                "fieldModel"           => [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 30
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 40
                        ],
                    ],
                ],
                "descriptionTextModel" => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 20
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designCatalogModel"   => [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardPriceDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPriceDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardOldPriceDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardOldPriceDesignTextModel"        => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1
                ],
                "hasImages"            => true,
                "useAutoload"          => true,
                "pageNavigationSize"   => 10,
                "shortCardDateType"    => 1,
                "fullCardDateType"     => 1,
                "hasRelations"         => true,
                "relationsLabel"       => "Relations label",
                "hasBin"               => true,
            ],
            null,
            [
                "designCatalogModel_fullCardContainerDesignBlockModel",
                "designCatalogModel_fullCardTitleDesignBlockModel",
                "designCatalogModel_fullCardTitleDesignTextModel",
                "designCatalogModel_fullCardDateDesignTextModel",
                "designCatalogModel_fullCardPriceDesignBlockModel",
                "designCatalogModel_fullCardPriceDesignTextModel",
                "designCatalogModel_fullCardOldPriceDesignBlockModel",
                "designCatalogModel_fullCardOldPriceDesignTextModel",
                "designCatalogModel_fullCardBinButtonDesignBlockModel",
                "designCatalogModel_fullCardBinButtonDesignTextModel",
            ]
        );
    }
}