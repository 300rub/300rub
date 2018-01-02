<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockOperationModel;

use testS\application\components\Operation;
use testS\models\blocks\block\BlockModel;
use testS\models\user\UserBlockOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

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
