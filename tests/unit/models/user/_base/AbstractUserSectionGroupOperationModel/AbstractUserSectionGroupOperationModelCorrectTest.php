<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSectionGroupOperationModel;

use testS\application\components\Operation;
use testS\models\user\UserSectionGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserSectionGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionGroupOperationModelCorrectTest extends AbstractCorrectModelTest
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
                    'operation' => Operation::SECTION_ADD,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SECTION_ADD,
                ],
            ],
            'correct2' => [
                [
                    'userId'    => 2,
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [
                    'userId'    => 2,
                    'operation' => Operation::SECTION_UPDATE,
                ],
            ],
        ];
    }
}
