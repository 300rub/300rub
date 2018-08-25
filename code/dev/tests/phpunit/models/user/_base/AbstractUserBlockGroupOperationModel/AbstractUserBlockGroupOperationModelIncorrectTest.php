<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserBlockGroupOperationModel;

use ss\application\components\user\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserBlockGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockGroupOperationModelIncorrectTest extends AbstractIncorrectModelTest
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
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [
                    'userId'    => 2,
                    'blockType' => BlockModel::TYPE_IMAGE,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
            ],
            'incorrect2' => [
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_IMAGE,
                    'operation' => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect4' => [
                [
                    'userId'    => 1,
                    'blockType' => 'incorrect',
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
