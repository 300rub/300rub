<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockOperationModel;

use testS\application\components\Operation;
use testS\models\blocks\block\BlockModel;
use testS\models\user\UserBlockOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserBlockOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockOperationModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockOperationModel
     */
    protected function getNewModel()
    {
        return new UserBlockOperationModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return array_merge(
            $this->_getDataProviderEmpty1(),
            $this->_getDataProviderEmpty2()
        );
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty1()
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
                    'userId'    => '',
                    'blockId'   => '',
                    'blockType' => '',
                    'operation' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty3' => [
                [
                    'userId'    => null,
                    'blockId'   => null,
                    'blockType' => null,
                    'operation' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty4' => [
                [
                    'userId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty5' => [
                [
                    'blockId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty6' => [
                [
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty7' => [
                [
                    'blockType' => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
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
            'empty8' => [
                [
                    'userId'    => 0,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty9' => [
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty10' => [
                [
                    'userId'    => 1,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty11' => [
                [
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty12' => [
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty13' => [
                [
                    'userId'    => 1,
                    'blockId'   => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty14' => [
                [
                    'userId'    => 1,
                    'blockId'   => 1,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }
}
