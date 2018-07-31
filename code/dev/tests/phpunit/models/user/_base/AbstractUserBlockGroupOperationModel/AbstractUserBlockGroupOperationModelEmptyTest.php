<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserBlockGroupOperationModel;

use ss\application\components\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserBlockGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockGroupOperationModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockGroupOperationModel
     */
    protected function getNewModel()
    {
        return new UserBlockGroupOperationModel();
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
                    'userId'    => '',
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
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty6' => [
                [
                    'userId'    => 0,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty7' => [
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty8' => [
                [
                    'userId'    => 1,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty9' => [
                [
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
