<?php

namespace testS\tests\unit\models;

use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\UserBlockGroupOperationModel;
use testS\models\UserBlockOperationModel;
use testS\models\UserModel;
use testS\models\UserSectionGroupOperationModel;
use testS\models\UserSectionOperationModel;
use testS\models\UserSettingsOperationModel;

/**
 * Tests for the model UserModel
 *
 * @package testS\tests\unit\models
 */
class UserModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserModel
     */
    protected function getNewModel()
    {
        return new UserModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
            "empty2" => [
                [
                    "login"    => "",
                    "password" => "",
                    "isOwner"  => "",
                    "name"     => "",
                    "email"    => "",
                ],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
            "empty3" => [
                [
                    "login"    => $this->generateStringWithLength(10),
                    "password" => $this->generateStringWithLength(40),
                    "name"     => $this->generateStringWithLength(10),
                    "email"    => "",
                ],
                [
                    "email" => ["required", "email"],
                ],
            ],
            "empty4" => [
                [
                    "login"    => null,
                    "password" => null,
                    "isOwner"  => null,
                    "name"     => null,
                    "email"    => null,
                ],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        $password1 = $this->generateStringWithLength(40);
        $password2 = $this->generateStringWithLength(40);

        return [
            "correct1" => [
                [
                    "login"    => "login1",
                    "password" => $password1,
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login"    => "login1",
                    "password" => $password1,
                    "isOwner"  => false,
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login"    => "login2",
                    "password" => $password2,
                    "name"     => "Name 2",
                    "email"    => "email2@email.com",
                ],
                [
                    "login"    => "login2",
                    "password" => $password2,
                    "isOwner"  => false,
                    "name"     => "Name 2",
                    "email"    => "email2@email.com",
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [
            "incorrect1" => [
                [
                    "login"    => "a",
                    "password" => "b",
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login"    => ["min"],
                    "password" => ["min"],
                ],
            ],
            "incorrect2" => [
                [
                    "login"    => $this->generateStringWithLength(51),
                    "password" => $this->generateStringWithLength(41),
                    "name"     => $this->generateStringWithLength(101),
                    "email"    => "email",
                ],
                [
                    "login"    => ["max"],
                    "password" => ["max"],
                    "name"     => ["max"],
                    "email"    => ["email"],
                ],
            ],
            "incorrect3" => [
                [
                    "login"    => "owner",
                    "password" => $this->generateStringWithLength(40),
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login" => ["unique"],
                ],
            ],
            "incorrect4" => [
                [
                    "login"    => "login 3",
                    "password" => $this->generateStringWithLength(40),
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login" => ["latinDigitUnderscoreHyphen"],
                ],
            ],
            "incorrect5" => [
                [
                    "login"    => "login1",
                    "password" => $this->generateStringWithLength(40),
                    "name"     => "Name",
                    "isOwner"  => true,
                    "email"    => "email@email.com",
                ],
                [
                    "isOwner" => false,
                ],
                [
                    "isOwner" => true,
                ],
                [
                    "isOwner" => false,
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "login"    => "login1",
                "password" => $this->generateStringWithLength(40),
                "name"     => "Name",
                "email"    => "email@email.com",
            ],
            [
                "login"    => ["required", "min"],
                "password" => ["required", "min"],
                "name"     => ["required"],
                "email"    => ["required", "email"],
            ]
        );
    }

    /**
     * Test for method getOperations()
     */
    public function testGetOperations()
    {
        $userModel = $this->getNewModel()->byId(4)->find();

        // Empty user (ID = 0)
        $expectedOperations = [];
        $actualOperations = $this->getNewModel()->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // There are no operations
        $expectedOperations = [];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Add one setting operation
        $userSettingsOperationModel = new UserSettingsOperationModel();
        $userSettingsOperationModel->set(
            [
                "userId"    => $userModel->getId(),
                "operation" => Operation::SETTING_SEO
            ]
        );
        $userSettingsOperationModel->save();
        $expectedOperations = [
            Operation::TYPE_SETTINGS => [
                Operation::SETTING_SEO
            ]
        ];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Add one operation for all sections
        $userSectionGroupOperationModel = new UserSectionGroupOperationModel();
        $userSectionGroupOperationModel->set(
            [
                "userId"    => $userModel->getId(),
                "operation" => Operation::SECTION_ADD
            ]
        );
        $userSectionGroupOperationModel->save();
        $expectedOperations = [
            Operation::TYPE_SECTIONS => [
                Operation::ALL => [
                    Operation::SECTION_ADD
                ]
            ],
            Operation::TYPE_SETTINGS => [
                Operation::SETTING_SEO
            ]
        ];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Add one operation for sections with ID = 1
        $userSectionOperationModel = new UserSectionOperationModel();
        $userSectionOperationModel->set(
            [
                "userId"    => $userModel->getId(),
                "sectionId" => 1,
                "operation" => Operation::SECTION_UPDATE
            ]
        );
        $userSectionOperationModel->save();
        $expectedOperations = [
            Operation::TYPE_SECTIONS => [
                Operation::ALL => [
                    Operation::SECTION_ADD
                ],
                1              => [
                    Operation::SECTION_UPDATE
                ]
            ],
            Operation::TYPE_SETTINGS => [
                Operation::SETTING_SEO
            ]
        ];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Add one operation for all text blocks
        $userBlockGroupOperationModel = new UserBlockGroupOperationModel();
        $userBlockGroupOperationModel->set(
            [
                "userId"    => $userModel->getId(),
                "blockType" => BlockModel::TYPE_TEXT,
                "operation" => Operation::TEXT_ADD
            ]
        );
        $userBlockGroupOperationModel->save();
        $expectedOperations = [
            Operation::TYPE_BLOCKS   => [
                BlockModel::TYPE_TEXT => [
                    Operation::ALL => [
                        Operation::TEXT_ADD
                    ]
                ]
            ],
            Operation::TYPE_SECTIONS => [
                Operation::ALL => [
                    Operation::SECTION_ADD
                ],
                1              => [
                    Operation::SECTION_UPDATE
                ]
            ],
            Operation::TYPE_SETTINGS => [
                Operation::SETTING_SEO
            ]
        ];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Add one operation for text blocks with ID = 1
        $userBlockOperationModel = new UserBlockOperationModel();
        $userBlockOperationModel->set(
            [
                "userId"    => $userModel->getId(),
                "blockId"   => 1,
                "blockType" => BlockModel::TYPE_TEXT,
                "operation" => Operation::TEXT_UPDATE_SETTINGS
            ]
        );
        $userBlockOperationModel->save();
        $expectedOperations = [
            Operation::TYPE_BLOCKS   => [
                BlockModel::TYPE_TEXT => [
                    Operation::ALL => [
                        Operation::TEXT_ADD
                    ],
                    1              => [
                        Operation::TEXT_UPDATE_SETTINGS
                    ]
                ]
            ],
            Operation::TYPE_SECTIONS => [
                Operation::ALL => [
                    Operation::SECTION_ADD
                ],
                1              => [
                    Operation::SECTION_UPDATE
                ]
            ],
            Operation::TYPE_SETTINGS => [
                Operation::SETTING_SEO
            ]
        ];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        // Delete all
        $userSettingsOperationModel->delete();
        $userSectionGroupOperationModel->delete();
        $userSectionOperationModel->delete();
        $userBlockGroupOperationModel->delete();
        $userBlockOperationModel->delete();
        $expectedOperations = [];
        $actualOperations = $userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);
    }
}