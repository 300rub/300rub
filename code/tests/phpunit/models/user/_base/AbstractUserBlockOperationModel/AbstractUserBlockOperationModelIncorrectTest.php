<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserBlockOperationModel;

use ss\application\components\user\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserBlockOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockOperationModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'userId'    => '  1  ',
                    'blockId'    => '  1  ',
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
                [
                    'userId'    => 1,
                    'blockId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
                [
                    'userId'    => 2,
                    'blockId'    => 2,
                    'blockType' => BlockModel::TYPE_IMAGE,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    'userId'    => 1,
                    'blockId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
            ],
            'incorrect2' => [
                [
                    'userId'    => 1,
                    'blockId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'userId'    => 1,
                    'blockId'    => 1,
                    'blockType' => BlockModel::TYPE_IMAGE,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect4' => [
                [
                    'userId'    => 1,
                    'blockId'    => 1,
                    'blockType' => 'incorrect',
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }
}
