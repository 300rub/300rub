<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionGroupOperationModel;

use ss\application\components\user\Operation;
use ss\models\user\UserSectionGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserSectionGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionGroupOperationModelIncorrectTest extends AbstractIncorrectModelTest
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
                    'operation' => Operation::SECTION_ADD,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SECTION_ADD,
                ],
                [
                    'userId'    => 2,
                    'operation' => Operation::SECTION_UPDATE_CONTENT,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SECTION_ADD,
                ],
            ],
            'incorrect2' => [
                [
                    'userId'    => 1,
                    'operation' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }
}
