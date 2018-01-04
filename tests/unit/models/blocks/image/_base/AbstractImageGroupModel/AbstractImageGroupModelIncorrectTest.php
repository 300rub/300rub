<?php

namespace testS\tests\unit\models\blocks\image\_base\AbstractImageGroupModel;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return ImageGroupModel
     */
    protected function getNewModel()
    {
        return new ImageGroupModel();
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
                    'imageId' => 'incorrect',
                    'name'    => 'incorrect',
                    'sort'    => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'imageId' => '1 asda',
                    'name'    => '<b>incorrect</b>',
                    'sort'    => ' 21 asd',
                ],
                [
                    'imageId' => 1,
                    'name'    => 'incorrect',
                    'sort'    => 21,
                ],
                [
                    'name'    => $this->generateStringWithLength(256),
                ],
                [
                    'name'    => ['maxLength'],
                ]
            ],
            'incorrect3' => [
                [
                    'imageId' => 999,
                    'name'    => 'Name',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
