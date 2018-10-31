<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractBlockModel;

use ss\models\blocks\block\BlockModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty2' => [
                [
                    'name'        => '',
                    'language'    => '',
                    'contentType' => '',
                    'contentId'   => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty3' => [
                [
                    'contentType' => 1,
                ],
                [
                    'name' => ['required']
                ],
            ],
            'empty4' => [
                [
                    'name'        => 'Name',
                    'contentType' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty5' => [
                [
                    'contentType' => 0,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }
}
