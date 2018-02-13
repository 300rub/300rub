<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\user\_base\AbstractUserBlockOperationModel;

use ss\application\components\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockOperationModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserBlockOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockOperationModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'userId'    => 1,
                    'blockId'   => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
                [
                    'userId'    => 1,
                    'blockId'   => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_CONTENT,
                ],
            ],
            'correct2' => [
                [
                    'userId'    => 2,
                    'blockId'   => 2,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    'userId'    => 2,
                    'blockId'   => 2,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
            ],
        ];
    }
}
