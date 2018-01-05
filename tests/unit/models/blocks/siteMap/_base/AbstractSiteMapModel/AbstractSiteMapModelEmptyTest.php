<?php

namespace testS\tests\unit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use testS\models\blocks\siteMap\SiteMapModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model SiteMapModel
 */
class AbstractSiteMapModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return SiteMapModel
     */
    protected function getNewModel()
    {
        return new SiteMapModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => $this->_getDataProviderEmpty1(),
            'empty2' => $this->_getDataProviderEmpty2(),
            'empty3' => $this->_getDataProviderEmpty3(),
            'empty4' => $this->_getDataProviderEmpty4(),
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty1()
    {
        return [
            [],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
            [
                'containerDesignBlockModel' => '',
                'itemDesignBlockModel'      => '',
                'itemDesignTextModel'       => '',
                'style'                     => '',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty2()
    {
        return [
            [
                'containerDesignBlockModel' => null,
                'itemDesignBlockModel'      => null,
                'itemDesignTextModel'       => null,
                'style'                     => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
            [
                'containerDesignBlockModel' => ' ',
                'itemDesignBlockModel'      => ' ',
                'itemDesignTextModel'       => ' ',
                'style'                     => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty3()
    {
        return [
            [
                'containerDesignBlockId' => ' ',
                'itemDesignBlockId'      => ' ',
                'itemDesignTextId'       => ' ',
                'style'                  => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
            [
                'containerDesignBlockId' => null,
                'itemDesignBlockId'      => null,
                'itemDesignTextId'       => null,
                'style'                  => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty4()
    {
        return [
            [
                'containerDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'itemDesignTextModel'       => [
                    'size' => ' '
                ],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
            [
                'containerDesignBlockModel' => [],
                'itemDesignBlockModel'      => [],
                'itemDesignTextModel'       => [],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'itemDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'itemDesignTextModel'       => [
                    'size' => 0
                ],
                'style'                     => 0,
            ],
        ];
    }
}
