<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockGroupOperationModel;

use testS\application\components\Operation;
use testS\models\blocks\block\BlockModel;
use testS\models\user\UserBlockGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserBlockGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockGroupOperationModelCorrectTest extends AbstractCorrectModelTest
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
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
                [
                    'userId'    => 1,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_ADD,
                ],
            ],
            'correct2' => [
                [
                    'userId'    => 2,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    'userId'    => 2,
                    'blockType' => BlockModel::TYPE_TEXT,
                    'operation' => Operation::TEXT_UPDATE_SETTINGS,
                ],
            ],
        ];
    }
}
