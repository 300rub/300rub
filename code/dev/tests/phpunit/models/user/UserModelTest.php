<?php

namespace ss\tests\phpunit\models\user;

use ss\application\components\Operation;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockGroupOperationModel;
use ss\models\user\UserBlockOperationModel;
use ss\models\user\UserModel;
use ss\models\user\UserSectionGroupOperationModel;
use ss\models\user\UserSectionOperationModel;
use ss\models\user\UserSettingsOperationModel;
use ss\tests\phpunit\models\_abstract\AbstractModelTest;

/**
 * Tests for the model UserModel
 */
class UserModelTest extends AbstractModelTest
{

    /**
     * User model
     *
     * @var UserModel
     */
    private $_userModel = null;

    /**
     * UserSettingsOperationModel
     *
     * @var UserSettingsOperationModel
     */
    private $_settings = null;

    /**
     * UserSectionGroupOperationModel
     *
     * @var UserSectionGroupOperationModel
     */
    private $_sectionGroup = null;

    /**
     * UserSectionOperationModel
     *
     * @var UserSectionOperationModel
     */
    private $_section = null;

    /**
     * UserBlockGroupOperationModel
     *
     * @var UserBlockGroupOperationModel
     */
    private $_blockGroup = null;

    /**
     * UserBlockOperationModel
     *
     * @var UserBlockOperationModel
     */
    private $_block = null;

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
     * Test for method getOperations()
     *
     * @return void
     */
    public function testGetOperations()
    {
        $this
            ->_setUser()
            ->_emptyUserTest()
            ->_noOperationTest()
            ->_addSettingOperationTest()
            ->_allSectionsOperationTest()
            ->_oneSectionsOperationTest()
            ->_allTextBlocksOperationTest()
            ->_oneTextBlocksOperationTest()
            ->_deleteAllOperations();
    }

    /**
     * Gets model by ID
     *
     * @param integer $modelId Model ID
     *
     * @return UserModel|AbstractModel
     */
    private function _getModelById($modelId)
    {
        return $this->getNewModel()->byId($modelId)->find();
    }

    /**
     * Sets user without operation
     *
     * @return UserModelTest
     */
    private function _setUser()
    {
        $this->_userModel = $this->_getModelById(4);
        return $this;
    }

    /**
     * Empty user (ID = 0)
     *
     * @return UserModelTest
     */
    private function _emptyUserTest()
    {
        $expectedOperations = [];
        $actualOperations = $this->getNewModel()->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * There are no operations
     *
     * @return UserModelTest
     */
    private function _noOperationTest()
    {
        $expectedOperations = [];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Adds one setting operation
     *
     * @return UserModelTest
     */
    private function _addSettingOperationTest()
    {
        $this->_settings = new UserSettingsOperationModel();
        $this->_settings->set(
            [
                'userId'    => $this->_userModel->getId(),
                'operation' => Operation::SETTINGS_ICON
            ]
        );
        $this->_settings->save();
        $expectedOperations = [
            Operation::TYPE_SETTINGS => [
                Operation::SETTINGS_ICON
            ]
        ];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Adds one operation for all sections
     *
     * @return UserModelTest
     */
    private function _allSectionsOperationTest()
    {
        $this->_sectionGroup = new UserSectionGroupOperationModel();
        $this->_sectionGroup->set(
            [
                'userId'    => $this->_userModel->getId(),
                'operation' => Operation::SECTION_ADD
            ]
        );
        $this->_sectionGroup->save();
        $expectedOperations = [
            Operation::TYPE_SECTIONS => [
                Operation::ALL => [
                    Operation::SECTION_ADD
                ]
            ],
            Operation::TYPE_SETTINGS => [
                Operation::SETTINGS_ICON
            ]
        ];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Adds one operation for one section
     *
     * @return UserModelTest
     */
    private function _oneSectionsOperationTest()
    {
        $this->_section = new UserSectionOperationModel();
        $this->_section->set(
            [
                'userId'    => $this->_userModel->getId(),
                'sectionId' => 1,
                'operation' => Operation::SECTION_UPDATE
            ]
        );
        $this->_section->save();
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
                Operation::SETTINGS_ICON
            ]
        ];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Adds one operation for all text blocks
     *
     * @return UserModelTest
     */
    private function _allTextBlocksOperationTest()
    {
        $this->_blockGroup = new UserBlockGroupOperationModel();
        $this->_blockGroup->set(
            [
                'userId'    => $this->_userModel->getId(),
                'blockType' => BlockModel::TYPE_TEXT,
                'operation' => Operation::TEXT_ADD
            ]
        );
        $this->_blockGroup->save();
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
                Operation::SETTINGS_ICON
            ]
        ];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Adds one operation for one text block
     *
     * @return UserModelTest
     */
    private function _oneTextBlocksOperationTest()
    {
        $this->_block = new UserBlockOperationModel();
        $this->_block->set(
            [
                'userId'    => $this->_userModel->getId(),
                'blockId'   => 1,
                'blockType' => BlockModel::TYPE_TEXT,
                'operation' => Operation::TEXT_UPDATE_SETTINGS
            ]
        );
        $this->_block->save();
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
                Operation::SETTINGS_ICON
            ]
        ];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }

    /**
     * Deletes all operations
     *
     * @return UserModelTest
     */
    private function _deleteAllOperations()
    {
        $this->_settings->delete();
        $this->_sectionGroup->delete();
        $this->_section->delete();
        $this->_blockGroup->delete();
        $this->_block->delete();
        $expectedOperations = [];
        $actualOperations = $this->_userModel->getOperations();
        $this->assertSame($expectedOperations, $actualOperations);

        return $this;
    }
}
