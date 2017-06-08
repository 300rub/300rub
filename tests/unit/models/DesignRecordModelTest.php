<?php

namespace testS\tests\unit\models;

use testS\models\DesignRecordModel;

/**
 * Tests for the model DesignRecordModel
 *
 * @package testS\tests\unit\models
 */
class DesignRecordModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordModel
     */
    protected function getNewModel()
    {
        return new DesignRecordModel();
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
                [
                    "shortCardContainerDesignBlockModel"      => "",
                    "shortCardInstanceDesignBlockModel"       => "",
                    "shortCardTitleDesignBlockModel"          => "",
                    "shortCardTitleDesignTextModel"           => "",
                    "shortCardDateDesignTextModel"            => "",
                    "shortCardDescriptionDesignBlockModel"    => "",
                    "shortCardDescriptionDesignTextModel"     => "",
                    "shortCardPaginationDesignBlockModel"     => "",
                    "shortCardPaginationItemDesignBlockModel" => "",
                    "shortCardPaginationItemDesignTextModel"  => "",
                    "fullCardTitleDesignBlockModel"           => "",
                    "fullCardTitleDesignTextModel"            => "",
                    "fullCardDateDesignTextModel"             => "",
                    "shortCardViewType"                       => "",
                    "fullCardImagesPosition"                  => "",
                    "fullCardDatePosition"                    => "",
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
            ],
            "empty2" => [
                [
                    "shortCardContainerDesignBlockModel"      => null,
                    "shortCardInstanceDesignBlockModel"       => null,
                    "shortCardTitleDesignBlockModel"          => null,
                    "shortCardTitleDesignTextModel"           => null,
                    "shortCardDateDesignTextModel"            => null,
                    "shortCardDescriptionDesignBlockModel"    => null,
                    "shortCardDescriptionDesignTextModel"     => null,
                    "shortCardPaginationDesignBlockModel"     => null,
                    "shortCardPaginationItemDesignBlockModel" => null,
                    "shortCardPaginationItemDesignTextModel"  => null,
                    "fullCardTitleDesignBlockModel"           => null,
                    "fullCardTitleDesignTextModel"            => null,
                    "fullCardDateDesignTextModel"             => null,
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
                [
                    "shortCardContainerDesignBlockModel"      => " ",
                    "shortCardInstanceDesignBlockModel"       => " ",
                    "shortCardTitleDesignBlockModel"          => " ",
                    "shortCardTitleDesignTextModel"           => " ",
                    "shortCardDateDesignTextModel"            => " ",
                    "shortCardDescriptionDesignBlockModel"    => " ",
                    "shortCardDescriptionDesignTextModel"     => " ",
                    "shortCardPaginationDesignBlockModel"     => " ",
                    "shortCardPaginationItemDesignBlockModel" => " ",
                    "shortCardPaginationItemDesignTextModel"  => " ",
                    "fullCardTitleDesignBlockModel"           => " ",
                    "fullCardTitleDesignTextModel"            => " ",
                    "fullCardDateDesignTextModel"             => " ",
                    "shortCardViewType"                       => " ",
                    "fullCardImagesPosition"                  => " ",
                    "fullCardDatePosition"                    => " ",
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
            ],
            "empty3" => [
                [
                    "shortCardContainerDesignBlockId"      => " ",
                    "shortCardInstanceDesignBlockId"       => " ",
                    "shortCardTitleDesignBlockId"          => " ",
                    "shortCardTitleDesignTextId"           => " ",
                    "shortCardDateDesignTextId"            => " ",
                    "shortCardDescriptionDesignBlockId"    => " ",
                    "shortCardDescriptionDesignTextId"     => " ",
                    "shortCardPaginationDesignBlockId"     => " ",
                    "shortCardPaginationItemDesignBlockId" => " ",
                    "shortCardPaginationItemDesignTextId"  => " ",
                    "fullCardTitleDesignBlockId"           => " ",
                    "fullCardTitleDesignTextId"            => " ",
                    "fullCardDateDesignTextId"             => " ",
                    "shortCardViewType"                    => " ",
                    "fullCardImagesPosition"               => " ",
                    "fullCardDatePosition"                 => " ",
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
                [
                    "shortCardContainerDesignBlockId"      => null,
                    "shortCardInstanceDesignBlockId"       => null,
                    "shortCardTitleDesignBlockId"          => null,
                    "shortCardTitleDesignTextId"           => null,
                    "shortCardDateDesignTextId"            => null,
                    "shortCardDescriptionDesignBlockId"    => null,
                    "shortCardDescriptionDesignTextId"     => null,
                    "shortCardPaginationDesignBlockId"     => null,
                    "shortCardPaginationItemDesignBlockId" => null,
                    "shortCardPaginationItemDesignTextId"  => null,
                    "fullCardTitleDesignBlockId"           => null,
                    "fullCardTitleDesignTextId"            => null,
                    "fullCardDateDesignTextId"             => null,
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
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => " "
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => " "
                    ],
                    "fullCardDateDesignTextModel"             => [
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
                [
                    "shortCardContainerDesignBlockModel"      => [],
                    "shortCardInstanceDesignBlockModel"       => [],
                    "shortCardTitleDesignBlockModel"          => [],
                    "shortCardTitleDesignTextModel"           => [],
                    "shortCardDateDesignTextModel"            => [],
                    "shortCardDescriptionDesignBlockModel"    => [],
                    "shortCardDescriptionDesignTextModel"     => [],
                    "shortCardPaginationDesignBlockModel"     => [],
                    "shortCardPaginationItemDesignBlockModel" => [],
                    "shortCardPaginationItemDesignTextModel"  => [],
                    "fullCardTitleDesignBlockModel"           => [],
                    "fullCardTitleDesignTextModel"            => [],
                    "fullCardDateDesignTextModel"             => [],
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
                        "size" => 20
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 20
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 20
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
                        "size" => 20
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 20
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 20
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1,
                ],
                [
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
                        "size" => 20
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 20
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 20
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
                        "size" => 20
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 20
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 20
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 1,
                    "fullCardDatePosition"                    => 1,
                ],
                [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0,
                ],
                [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 10
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 10
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 10
                    ],
                    "shortCardViewType"                       => 0,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 0,
                ],
            ],
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
                    "shortCardContainerDesignBlockModel"      => "incorrect",
                    "shortCardInstanceDesignBlockModel"       => "incorrect",
                    "shortCardTitleDesignBlockModel"          => "incorrect",
                    "shortCardTitleDesignTextModel"           => "incorrect",
                    "shortCardDateDesignTextModel"            => "incorrect",
                    "shortCardDescriptionDesignBlockModel"    => "incorrect",
                    "shortCardDescriptionDesignTextModel"     => "incorrect",
                    "shortCardPaginationDesignBlockModel"     => "incorrect",
                    "shortCardPaginationItemDesignBlockModel" => "incorrect",
                    "shortCardPaginationItemDesignTextModel"  => "incorrect",
                    "fullCardTitleDesignBlockModel"           => "incorrect",
                    "fullCardTitleDesignTextModel"            => "incorrect",
                    "fullCardDateDesignTextModel"             => "incorrect",
                    "shortCardViewType"                       => "incorrect",
                    "fullCardImagesPosition"                  => "incorrect",
                    "fullCardDatePosition"                    => "incorrect",
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
                [
                    "shortCardViewType"      => 999,
                    "fullCardImagesPosition" => 999,
                    "fullCardDatePosition"   => 999,
                ],
                [
                    "shortCardViewType"      => 0,
                    "fullCardImagesPosition" => 0,
                    "fullCardDatePosition"   => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "shortCardViewType"      => " 1 ",
                    "fullCardImagesPosition" => " 1 ",
                    "fullCardDatePosition"   => " 1 ",
                ],
                [
                    "shortCardViewType"      => 1,
                    "fullCardImagesPosition" => 1,
                    "fullCardDatePosition"   => 1,
                ],
                [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => " 500 "
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => " 500 "
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => " 500 "
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => " 500 "
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => " 500 "
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => " 500 "
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => " 500 "
                    ],
                    "shortCardViewType"                       => true,
                    "fullCardImagesPosition"                  => false,
                    "fullCardDatePosition"                    => true,
                ],
                [
                    "shortCardContainerDesignBlockModel"      => [
                        "marginTop" => 500
                    ],
                    "shortCardInstanceDesignBlockModel"       => [
                        "marginTop" => 500
                    ],
                    "shortCardTitleDesignBlockModel"          => [
                        "marginTop" => 500
                    ],
                    "shortCardTitleDesignTextModel"           => [
                        "size" => 500
                    ],
                    "shortCardDateDesignTextModel"            => [
                        "size" => 500
                    ],
                    "shortCardDescriptionDesignBlockModel"    => [
                        "marginTop" => 500
                    ],
                    "shortCardDescriptionDesignTextModel"     => [
                        "size" => 500
                    ],
                    "shortCardPaginationDesignBlockModel"     => [
                        "marginTop" => 500
                    ],
                    "shortCardPaginationItemDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "shortCardPaginationItemDesignTextModel"  => [
                        "size" => 500
                    ],
                    "fullCardTitleDesignBlockModel"           => [
                        "marginTop" => 500
                    ],
                    "fullCardTitleDesignTextModel"            => [
                        "size" => 500
                    ],
                    "fullCardDateDesignTextModel"             => [
                        "size" => 500
                    ],
                    "shortCardViewType"                       => 1,
                    "fullCardImagesPosition"                  => 0,
                    "fullCardDatePosition"                    => 1,
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
                    "size" => 20
                ],
                "shortCardDateDesignTextModel"            => [
                    "size" => 20
                ],
                "shortCardDescriptionDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardDescriptionDesignTextModel"     => [
                    "size" => 20
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
                    "size" => 20
                ],
                "fullCardTitleDesignBlockModel"           => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardTitleDesignTextModel"            => [
                    "size" => 20
                ],
                "fullCardDateDesignTextModel"             => [
                    "size" => 20
                ],
                "shortCardViewType"                       => 1,
                "fullCardImagesPosition"                  => 1,
                "fullCardDatePosition"                    => 1,
            ],
            [
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
                    "size" => 20
                ],
                "shortCardDateDesignTextModel"            => [
                    "size" => 20
                ],
                "shortCardDescriptionDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardDescriptionDesignTextModel"     => [
                    "size" => 20
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
                    "size" => 20
                ],
                "fullCardTitleDesignBlockModel"           => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardTitleDesignTextModel"            => [
                    "size" => 20
                ],
                "fullCardDateDesignTextModel"             => [
                    "size" => 20
                ],
                "shortCardViewType"                       => 1,
                "fullCardImagesPosition"                  => 1,
                "fullCardDatePosition"                    => 1,
            ]
        );
    }
}