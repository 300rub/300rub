<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\user\_base\AbstractUserSectionOperationModel;

use ss\application\components\Operation;
use ss\models\user\UserSectionOperationModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserSectionOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionOperationModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty2' => [
                [
                    'userId'    => '',
                    'sectionId' => '',
                    'operation' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty3' => [
                [
                    'userId'    => null,
                    'sectionId' => null,
                    'operation' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty4' => [
                [
                    'userId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty5' => [
                [
                    'operation' => Operation::SECTION_DUPLICATE
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty6' => [
                [
                    'userId'    => 0,
                    'operation' => Operation::SECTION_DUPLICATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty7' => [
                [
                    'userId'    => 1,
                    'operation' => Operation::SECTION_DUPLICATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty8' => [
                [
                    'userId'    => 1,
                    'sectionId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty9' => [
                [
                    'sectionId' => 1,
                    'operation' => Operation::SECTION_DUPLICATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
