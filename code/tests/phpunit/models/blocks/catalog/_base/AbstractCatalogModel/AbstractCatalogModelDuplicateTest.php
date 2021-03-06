<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogModel;

use ss\models\blocks\catalog\CatalogModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogModel
 */
class AbstractCatalogModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'imageModel'           => $this->_imageModelCreateData(),
                'tabModel'             => $this->_tabModelCreateData(),
                'fieldModel'           => $this->_fieldModelCreateData(),
                'descriptionTextModel'
                    => $this->_descriptionTextModelCreateData(),
                'designCatalogModel'   => array_merge(
                    $this->_designCatalogModelCreateData1(),
                    $this->_designCatalogModelCreateData2()
                ),
                'hasImages'            => true,
                'useAutoload'          => true,
                'pageNavigationSize'   => 10,
                'shortCardDateType'    => 1,
                'fullCardDateType'     => 1,
                'hasRelations'         => true,
                'relationsLabel'       => 'Relations label',
                'hasBin'               => true,
            ],
            [
                'imageModel'           => $this->_imageModelExpectData(),
                'tabModel'             => $this->_tabModelExpectData(),
                'descriptionTextModel'
                    => $this->_descriptionTextModelExpectData(),
                'designCatalogModel'
                    => $this->_designCatalogModelExpectData(),
                'hasImages'            => true,
                'useAutoload'          => true,
                'pageNavigationSize'   => 10,
                'shortCardDateType'    => 1,
                'fullCardDateType'     => 1,
                'hasRelations'         => true,
                'relationsLabel'       => 'Relations label',
                'hasBin'               => true,
            ],
            null,
            [
                'imageModel',
                'tabModel',
                'fieldModel',
                'descriptionTextModel',
                'designCatalogModel',
            ]
        );
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _imageModelCreateData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 10,
            ],
            'designImageSliderModel' => [
                'arrowDesignTextModel' => [
                    'size' => 10
                ],
                'hasAutoPlay'          => true,
                'playSpeed'            => 10,
            ],
            'designImageZoomModel'   => [
                'designBlockModel' => [
                    'marginTop' => 20
                ],
                'effect'           => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 20
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 30
                ],
                'alignment'                 => 1
            ],
            'type'                   => 1,
            'viewAutoCropType'       => 1,
            'viewCropX'              => 30,
            'viewCropY'              => 40,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 20,
            'thumbCropY'             => 30,
            'useAlbums'              => true,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _tabModelCreateData()
    {
        return [
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignBlockModel'       => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignTextModel'        => [
                    'size' => 20
                ],
                'contentDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'type'             => 1,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => true,
            'isLazyLoad'      => true,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _fieldModelCreateData()
    {
        return [
            'designFieldModel' => [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 20
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 30
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 40
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _descriptionTextModelCreateData()
    {
        return [
            'designTextModel'  => [
                'size' => 10
            ],
            'designBlockModel' => [
                'marginTop' => 20
            ],
            'type'             => 1,
            'hasEditor'        => false
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _designCatalogModelCreateData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 10
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 10
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 10
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _designCatalogModelCreateData2()
    {
        return [
            'fullCardContainerDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 10
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 10
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _imageModelExpectData()
    {
        return [
            'type'              => 1,
            'viewAutoCropType'  => 1,
            'viewCropX'         => 30,
            'viewCropY'         => 40,
            'thumbAutoCropType' => 1,
            'thumbCropX'        => 20,
            'thumbCropY'        => 30,
            'useAlbums'         => true,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _tabModelExpectData()
    {
        return [
            'isShowEmpty'     => true,
            'isLazyLoad'      => true,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _descriptionTextModelExpectData()
    {
        return [
            'type'             => 1,
            'hasEditor'        => false
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _designCatalogModelExpectData()
    {
        return [
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1
        ];
    }
}
