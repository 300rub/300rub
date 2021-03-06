<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionGroupOperationModel;

use ss\application\components\user\Operation;
use ss\models\user\UserSectionGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
                    'operation' => Operation::SECTION_UPDATE_CONTENT,
                ],
                [
                    'userId'    => 2,
                    'operation' => Operation::SECTION_UPDATE_CONTENT,
                ],
            ],
        ];
    }
}
