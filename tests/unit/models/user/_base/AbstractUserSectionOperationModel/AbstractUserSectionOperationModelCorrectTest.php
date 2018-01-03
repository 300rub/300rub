<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSectionOperationModel;

use testS\application\components\Operation;
use testS\models\user\UserSectionOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserSectionOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionOperationModelCorrectTest extends AbstractCorrectModelTest
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
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_DUPLICATE,
                ],
                [
                    'userId'    => 1,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_DUPLICATE,
                ],
            ],
            'correct2' => [
                [
                    'userId'    => 2,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_UPDATE,
                ],
                [
                    'userId'    => 2,
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_UPDATE,
                ],
            ],
        ];
    }
}
