<?php

namespace testS\tests\unit\models;

use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return BlockModel
     */
    protected function getNewModel()
    {
        return new BlockModel();
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2(),
            'incorrect3' => $this->_getDataProviderIncorrect3(),
            'incorrect4' => $this->_getDataProviderIncorrect4(),
            'incorrect5' => $this->_getDataProviderIncorrect5(),
            'incorrect6' => $this->_getDataProviderIncorrect6(),
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect1()
    {
        $textModel1 = new TextModel();
        $textModel1->save();

        return [
            [
                'name'        => '    Block name   ',
                'language'    => '  1 ',
                'contentType' => '  1  ',
                'contentId'   => '  ' . $textModel1->getId() . '  ',
            ],
            [
                'name'        => 'Block name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => $textModel1->getId(),
            ],
            [
                'name'        => '   New name   ',
                'language'    => 2,
                'contentType' => 2,
            ],
            [
                'name'        => 'New name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => $textModel1->getId(),
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        return [
            [
                'name'        => $this->generateStringWithLength('256'),
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => 1,
            ],
            [
                'name' => ['maxLength']
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect3()
    {
        $textModel2 = new TextModel();
        $textModel2->save();

        return [
            [
                'name'        => 'Name',
                'language'    => 999,
                'contentType' => 1,
                'contentId'   => $textModel2->getId(),
            ],
            [
                'name'        => 'Name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => $textModel2->getId(),
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect4()
    {
        return [
            [
                'name'        => 'Name',
                'language'    => 1,
                'contentType' => 999,
                'contentId'   => 1,
            ],
            [],
            null,
            null,
            self::EXCEPTION_CONTENT
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect5()
    {
        return [
            [
                'name'        => 'Name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => 999,
            ],
            [],
            null,
            null,
            self::EXCEPTION_MODEL
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect6()
    {
        $textModel3 = new TextModel();
        $textModel3->save();

        return [
            [
                'name'        => '<b>  Block name   </b>',
                'language'    => '  1 a',
                'contentType' => '  1  d',
                'contentId'   => '  ' . $textModel3->getId() . ' f',
            ],
            [
                'name'        => 'Block name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => $textModel3->getId(),
            ],
            [
                'name' => '<strong>New name   ',
            ],
            [
                'name'        => 'New name',
                'language'    => 1,
                'contentType' => 1,
                'contentId'   => $textModel3->getId(),
            ]
        ];
    }
}
