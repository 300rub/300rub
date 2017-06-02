<?php

namespace testS\tests\unit\models;

use testS\models\DesignCatalogModel;

/**
 * Tests for the model DesignCatalogModel
 *
 * @package testS\tests\unit\models
 */
class DesignCatalogModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignCatalogModel
     */
    protected function getNewModel()
    {
        return new DesignCatalogModel();
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
                [
                    "shortCardContainerDesignBlockModel"      => "",
                    "shortCardInstanceDesignBlockModel"       => "",
                    "shortCardTitleDesignBlockModel"          => "",
                    "shortCardTitleDesignTextModel"           => "",
                    "shortCardDateDesignTextModel"            => "",
                    "shortCardPriceDesignBlockModel"          => "",
                    "shortCardPriceDesignTextModel"           => "",
                    "shortCardOldPriceDesignBlockModel"       => "",
                    "shortCardOldPriceDesignTextModel"        => "",
                    "shortCardDescriptionDesignBlockModel"    => "",
                    "shortCardDescriptionDesignTextModel"     => "",
                    "shortCardPaginationDesignBlockModel"     => "",
                    "shortCardPaginationItemDesignBlockModel" => "",
                    "shortCardPaginationItemDesignTextModel"  => "",
                    "fullCardContainerDesignBlockModel"       => "",
                    "fullCardTitleDesignBlockModel"           => "",
                    "fullCardTitleDesignTextModel"            => "",
                    "fullCardDateDesignTextModel"             => "",
                    "fullCardPriceDesignBlockModel"           => "",
                    "fullCardPriceDesignTextModel"            => "",
                    "fullCardOldPriceDesignBlockModel"        => "",
                    "fullCardOldPriceDesignTextModel"         => "",
                    "fullCardBinButtonDesignBlockModel"       => "",
                    "fullCardBinButtonDesignTextModel"        => "",
                    "shortCardViewType"                       => "",
                    "fullCardImagesPosition"                  => "",
                    "fullCardDatePosition"                    => ""
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
            ],
            "empty2" => [
                [
                    "shortCardContainerDesignBlockModel"      => null,
                    "shortCardInstanceDesignBlockModel"       => null,
                    "shortCardTitleDesignBlockModel"          => null,
                    "shortCardTitleDesignTextModel"           => null,
                    "shortCardDateDesignTextModel"            => null,
                    "shortCardPriceDesignBlockModel"          => null,
                    "shortCardPriceDesignTextModel"           => null,
                    "shortCardOldPriceDesignBlockModel"       => null,
                    "shortCardOldPriceDesignTextModel"        => null,
                    "shortCardDescriptionDesignBlockModel"    => null,
                    "shortCardDescriptionDesignTextModel"     => null,
                    "shortCardPaginationDesignBlockModel"     => null,
                    "shortCardPaginationItemDesignBlockModel" => null,
                    "shortCardPaginationItemDesignTextModel"  => null,
                    "fullCardContainerDesignBlockModel"       => null,
                    "fullCardTitleDesignBlockModel"           => null,
                    "fullCardTitleDesignTextModel"            => null,
                    "fullCardDateDesignTextModel"             => null,
                    "fullCardPriceDesignBlockModel"           => null,
                    "fullCardPriceDesignTextModel"            => null,
                    "fullCardOldPriceDesignBlockModel"        => null,
                    "fullCardOldPriceDesignTextModel"         => null,
                    "fullCardBinButtonDesignBlockModel"       => null,
                    "fullCardBinButtonDesignTextModel"        => null,
                    "shortCardViewType"                       => null,
                    "fullCardImagesPosition"                  => null,
                    "fullCardDatePosition"                    => null,
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
                [
                    "shortCardContainerDesignBlockModel"      => " ",
                    "shortCardInstanceDesignBlockModel"       => " ",
                    "shortCardTitleDesignBlockModel"          => " ",
                    "shortCardTitleDesignTextModel"           => " ",
                    "shortCardDateDesignTextModel"            => " ",
                    "shortCardPriceDesignBlockModel"          => " ",
                    "shortCardPriceDesignTextModel"           => " ",
                    "shortCardOldPriceDesignBlockModel"       => " ",
                    "shortCardOldPriceDesignTextModel"        => " ",
                    "shortCardDescriptionDesignBlockModel"    => " ",
                    "shortCardDescriptionDesignTextModel"     => " ",
                    "shortCardPaginationDesignBlockModel"     => " ",
                    "shortCardPaginationItemDesignBlockModel" => " ",
                    "shortCardPaginationItemDesignTextModel"  => " ",
                    "fullCardContainerDesignBlockModel"       => " ",
                    "fullCardTitleDesignBlockModel"           => " ",
                    "fullCardTitleDesignTextModel"            => " ",
                    "fullCardDateDesignTextModel"             => " ",
                    "fullCardPriceDesignBlockModel"           => " ",
                    "fullCardPriceDesignTextModel"            => " ",
                    "fullCardOldPriceDesignBlockModel"        => " ",
                    "fullCardOldPriceDesignTextModel"         => " ",
                    "fullCardBinButtonDesignBlockModel"       => " ",
                    "fullCardBinButtonDesignTextModel"        => " ",
                    "shortCardViewType"                       => " ",
                    "fullCardImagesPosition"                  => " ",
                    "fullCardDatePosition"                    => " "
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
            ],
            "empty3" => [
                [
                    "shortCardContainerDesignBlockId"      => "",
                    "shortCardInstanceDesignBlockId"       => "",
                    "shortCardTitleDesignBlockId"          => "",
                    "shortCardTitleDesignTextId"           => "",
                    "shortCardDateDesignTextId"            => "",
                    "shortCardPriceDesignBlockId"          => "",
                    "shortCardPriceDesignTextId"           => "",
                    "shortCardOldPriceDesignBlockId"       => "",
                    "shortCardOldPriceDesignTextId"        => "",
                    "shortCardDescriptionDesignBlockId"    => "",
                    "shortCardDescriptionDesignTextId"     => "",
                    "shortCardPaginationDesignBlockId"     => "",
                    "shortCardPaginationItemDesignBlockId" => "",
                    "shortCardPaginationItemDesignTextId"  => "",
                    "fullCardContainerDesignBlockId"       => "",
                    "fullCardTitleDesignBlockId"           => "",
                    "fullCardTitleDesignTextId"            => "",
                    "fullCardDateDesignTextId"             => "",
                    "fullCardPriceDesignBlockId"           => "",
                    "fullCardPriceDesignTextId"            => "",
                    "fullCardOldPriceDesignBlockId"        => "",
                    "fullCardOldPriceDesignTextId"         => "",
                    "fullCardBinButtonDesignBlockId"       => "",
                    "fullCardBinButtonDesignTextId"        => "",
                    "shortCardViewType"                    => "",
                    "fullCardImagesPosition"               => "",
                    "fullCardDatePosition"                 => ""
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
                [
                    "shortCardContainerDesignBlockId"      => null,
                    "shortCardInstanceDesignBlockId"       => null,
                    "shortCardTitleDesignBlockId"          => null,
                    "shortCardTitleDesignTextId"           => null,
                    "shortCardDateDesignTextId"            => null,
                    "shortCardPriceDesignBlockId"          => null,
                    "shortCardPriceDesignTextId"           => null,
                    "shortCardOldPriceDesignBlockId"       => null,
                    "shortCardOldPriceDesignTextId"        => null,
                    "shortCardDescriptionDesignBlockId"    => null,
                    "shortCardDescriptionDesignTextId"     => null,
                    "shortCardPaginationDesignBlockId"     => null,
                    "shortCardPaginationItemDesignBlockId" => null,
                    "shortCardPaginationItemDesignTextId"  => null,
                    "fullCardContainerDesignBlockId"       => null,
                    "fullCardTitleDesignBlockId"           => null,
                    "fullCardTitleDesignTextId"            => null,
                    "fullCardDateDesignTextId"             => null,
                    "fullCardPriceDesignBlockId"           => null,
                    "fullCardPriceDesignTextId"            => null,
                    "fullCardOldPriceDesignBlockId"        => null,
                    "fullCardOldPriceDesignTextId"         => null,
                    "fullCardBinButtonDesignBlockId"       => null,
                    "fullCardBinButtonDesignTextId"        => null,
                    "shortCardViewType"                    => null,
                    "fullCardImagesPosition"               => null,
                    "fullCardDatePosition"                 => null,
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
            ],
            "empty4" => [
                [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop" => " "
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop" => " "
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => " "
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => " "
                    ],
                    "shortCardPriceDesignBlockModel"          => [
                        "marginTop" => " "
                    ],
                    "shortCardPriceDesignTextModel"           => [
                        "size" => " "
                    ],
                    "shortCardOldPriceDesignBlockModel"       => [
                        "marginTop" => " "
                    ],
                    "shortCardOldPriceDesignTextModel"        => [
                        "size" => " "
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop" => " "
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => " "
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => " "
                    ],
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => " "
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => " "
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => " "
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => " "
                    ],
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => " "
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => " "
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => " "
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => " "
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => " "
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => " "
                    ],
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
                [
                    "shortCardContainerDesignBlockModel"      => [],
                    "shortCardInstanceDesignBlockModel"       => [],
                    "shortCardTitleDesignBlockModel"          => [],
                    "shortCardTitleDesignTextModel"           => [],
                    "shortCardDateDesignTextModel"            => [],
                    "shortCardPriceDesignBlockModel"          => [],
                    "shortCardPriceDesignTextModel"           => [],
                    "shortCardOldPriceDesignBlockModel"       => [],
                    "shortCardOldPriceDesignTextModel"        => [],
                    "shortCardDescriptionDesignBlockModel"    => [],
                    "shortCardDescriptionDesignTextModel"     => [],
                    "shortCardPaginationDesignBlockModel"     => [],
                    "shortCardPaginationItemDesignBlockModel" => [],
                    "shortCardPaginationItemDesignTextModel"  => [],
                    "fullCardContainerDesignBlockModel"       => [],
                    "fullCardTitleDesignBlockModel"           => [],
                    "fullCardTitleDesignTextModel"            => [],
                    "fullCardDateDesignTextModel"             => [],
                    "fullCardPriceDesignBlockModel"           => [],
                    "fullCardPriceDesignTextModel"            => [],
                    "fullCardOldPriceDesignBlockModel"        => [],
                    "fullCardOldPriceDesignTextModel"         => [],
                    "fullCardBinButtonDesignBlockModel"       => [],
                    "fullCardBinButtonDesignTextModel"        => [],
                ],
                [
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
                    "fullCardContainerDesignBlockModel"       => [
                        "marginTop" => 0
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
                    "fullCardPriceDesignBlockModel"           => [
                        "marginTop" => 0
                    ],
                    "fullCardPriceDesignTextModel"            => [
                        "size" => 0
                    ],
                    "fullCardOldPriceDesignBlockModel"        => [
                        "marginTop" => 0
                    ],
                    "fullCardOldPriceDesignTextModel"         => [
                        "size" => 0
                    ],
                    "fullCardBinButtonDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "fullCardBinButtonDesignTextModel"        => [
                        "size" => 0
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0
                ],
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
        //$this->markTestSkipped();
        return [];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        //$this->markTestSkipped();
        return [];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}