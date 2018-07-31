<?php

namespace ss\tests\phpunit\models\blocks\helpers\file\_base\AbstractFileModel;

use ss\models\blocks\helpers\file\FileModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFileModel
 */
class AbstractFileModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return FileModel
     */
    protected function getNewModel()
    {
        return new FileModel();
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
                    'originalName' => $this->generateStringWithLength(256),
                    'type'         => 'image/jpeg',
                    'size'         => 1024000,
                    'uniqueName'   => 'akr84ndkro.jpg',
                ],
                [
                    'originalName' => ['maxLength'],
                ],
            ],
            'incorrect2' => [
                [
                    'originalName' => 'Original_name.jpg',
                    'type'         => $this->generateStringWithLength(51),
                    'size'         => 1024000,
                    'uniqueName'   => 'akr84ndkro.jpg',
                ],
                [
                    'type' => ['maxLength'],
                ],
            ],
            'incorrect3' => [
                [
                    'originalName' => 'Original_name.jpg',
                    'type'         => 'image/jpeg',
                    'size'         => 1024000,
                    'uniqueName'   => $this->generateStringWithLength(26),
                ],
                [
                    'uniqueName' => ['maxLength'],
                ],
            ],
            'incorrect4' => [
                [
                    'originalName' => 111111,
                    'type'         => 2222,
                    'size'         => '1024000',
                    'uniqueName'   => 4124124,
                ],
                [
                    'originalName' => '111111',
                    'type'         => '2222',
                    'size'         => 1024000,
                    'uniqueName'   => '4124124',
                ],
            ],
            'incorrect5' => [
                [
                    'originalName' => '<b>aaa</b>',
                    'type'         => '<b> bbb </b>',
                    'size'         => '1024000 asdasd',
                    'uniqueName'   => '  <b> ccc </b>',
                ],
                [
                    'originalName' => 'aaa',
                    'type'         => 'bbb',
                    'size'         => 1024000,
                    'uniqueName'   => 'ccc',
                ],
            ],
        ];
    }
}
