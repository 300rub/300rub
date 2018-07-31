<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserBlockOperationModel;

use ss\application\components\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserBlockOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockOperationModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'userId'    => 1,
                'blockId'   => 1,
                'blockType' => BlockModel::TYPE_TEXT,
                'operation' => Operation::TEXT_UPDATE_CONTENT,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
