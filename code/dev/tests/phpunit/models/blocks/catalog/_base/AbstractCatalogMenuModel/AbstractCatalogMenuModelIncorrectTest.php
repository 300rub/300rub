<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogMenuModel
 */
class AbstractCatalogMenuModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogMenuModel
     */
    protected function getNewModel()
    {
        return new CatalogMenuModel();
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'parentId'  => 'incorrect',
                    'seoModel'  => 'incorrect',
                    'catalogId' => 'incorrect',
                    'icon'      => 'incorrect',
                    'subName'   => 'incorrect',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'parentId'  => '  1 ',
                    'seoModel'  => [
                        'name' => '  as asd <b> as </b> '
                    ],
                    'catalogId' => ' 1 asd',
                    'icon'      => '<b> 123 </b>',
                    'subName'   => '<b> 123 </b>',
                ],
                [
                    'parentId'  => 1,
                    'seoModel'  => [
                        'name' => 'as asd  as',
                        'alias'  => 'as-asd--as'
                    ],
                    'catalogId' => 1,
                    'icon'      => '123',
                    'subName'   => '123',
                ],
                [
                    'icon'    => $this->generateStringWithLength(51),
                    'subName' => $this->generateStringWithLength(256),
                ],
                [
                    'icon'    => ['maxLength'],
                    'subName' => ['maxLength'],
                ],
            ]
        ];
    }
}
