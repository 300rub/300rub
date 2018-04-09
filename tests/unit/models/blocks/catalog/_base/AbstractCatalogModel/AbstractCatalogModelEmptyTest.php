<?php

namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogModel;

use ss\models\blocks\catalog\CatalogModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogModel
 */
class AbstractCatalogModelEmptyTest extends AbstractEmptyModelTest
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
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'imageModel'           => $this->_imageModelData(),
                    'tabModel'             => $this->_tabModelData(),
                    'fieldModel'           => $this->_fieldModelData(),
                    'descriptionTextModel' => $this->_descriptionTextModel(),
                    'designCatalogModel'   => $this->_designCatalogModelData(),
                    'hasImages'            => false,
                    'useAutoload'          => false,
                    'pageNavigationSize'   => 0,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                    'hasRelations'         => false,
                    'relationsLabel'       => '',
                    'hasBin'               => false,
                ],
                null,
                null,
                null,
                null,
                [
                    'designCatalogModel_fullCardContainerDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignTextModel',
                    'designCatalogModel_fullCardDateDesignTextModel',
                    'designCatalogModel_fullCardPriceDesignBlockModel',
                    'designCatalogModel_fullCardPriceDesignTextModel',
                    'designCatalogModel_fullCardOldPriceDesignBlockModel',
                    'designCatalogModel_fullCardOldPriceDesignTextModel',
                    'designCatalogModel_fullCardBinButtonDesignBlockModel',
                    'designCatalogModel_fullCardBinButtonDesignTextModel',
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _imageModelData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 0,
            ],
            'designImageSliderModel' => [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            'designImageZoomModel'   => [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            'type'                   => 0,
            'autoCropType'           => 0,
            'cropWidth'              => 0,
            'cropHeight'             => 0,
            'cropX'                  => 0,
            'cropY'                  => 0,
            'thumbAutoCropType'      => 0,
            'thumbCropX'             => 0,
            'thumbCropY'             => 0,
            'useAlbums'              => false,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _tabModelData()
    {
        return [
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'tabDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'tabDesignTextModel'        => [
                    'size' => 0
                ],
                'contentDesignBlockModel'   => [
                    'marginTop' => 0
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => false,
            'isLazyLoad'      => false,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _fieldModelData()
    {
        return [
            'designFieldModel' => [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _descriptionTextModel()
    {
        return [
            'designTextModel'  => [
                'size' => 0
            ],
            'designBlockModel' => [
                'marginTop' => 0
            ],
            'type'             => 0,
            'hasEditor'        => false
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _designCatalogModelData()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }
}
