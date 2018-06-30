<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\user\_base\AbstractUserSectionOperationModel;

use ss\application\components\Operation;
use ss\models\user\UserSectionOperationModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserSectionOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionOperationModelIncorrectTest extends AbstractIncorrectModelTest
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
                    'sectionId' => '  1  ',
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [
                    'userId'    => 1,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [
                    'userId'    => 2,
                    'sectionId' => 2,
                    'operation' => Operation::SECTION_DESIGN_UPDATE,
                ],
                [
                    'userId'    => 1,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_UPDATE,
                ],
            ],
            'incorrect2' => [
                [
                    'userId'    => 1,
                    'sectionId' => 1,
                    'operation' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'incorrect3' => [
                [
                    'userId'    => 999,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect4' => [
                [
                    'userId'    => 1,
                    'sectionId' => 999,
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
