<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionGroupOperationModel;

use ss\application\components\Operation;
use ss\models\user\UserSectionGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserSectionGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionGroupOperationModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionGroupOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionGroupOperationModel();
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
                'operation' => Operation::SECTION_ADD,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
