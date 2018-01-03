<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSectionGroupOperationModel;

use testS\application\components\Operation;
use testS\models\user\UserSectionGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                    'operation' => Operation::SECTION_UPDATE,
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
