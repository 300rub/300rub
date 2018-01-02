<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockGroupOperationModel;

use testS\application\components\Operation;
use testS\models\blocks\block\BlockModel;
use testS\models\user\UserBlockGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserBlockGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockGroupOperationModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'userId'    => 1,
                'blockType' => BlockModel::TYPE_TEXT,
                'operation' => Operation::TEXT_ADD,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
