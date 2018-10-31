<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionOperationModel;

use ss\application\components\user\Operation;
use ss\models\user\UserSectionOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserSectionOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionOperationModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionOperationModel();
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
                'sectionId' => 1,
                'operation' => Operation::SECTION_UPDATE_CONTENT,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
