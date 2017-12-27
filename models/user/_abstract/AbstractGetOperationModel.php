<?php

namespace testS\models\user\_abstract;

use testS\application\components\Operation;
use testS\models\user\_base\AbstractUserModel;
use testS\models\user\UserBlockGroupOperationModel;
use testS\models\user\UserBlockOperationModel;
use testS\models\user\UserSectionGroupOperationModel;
use testS\models\user\UserSectionOperationModel;
use testS\models\user\UserSettingsOperationModel;

/**
 * Abstract model to get user operations
 */
abstract class AbstractGetOperationModel extends AbstractUserModel
{

    /**
     * Operations
     *
     * @var array
     */
    private $_operations = [
        Operation::TYPE_BLOCKS   => [],
        Operation::TYPE_SECTIONS => [],
        Operation::TYPE_SETTINGS => [],
    ];

    /**
     * Gets operations by user ID
     *
     * @return array
     */
    public function getOperations()
    {
        if ($this->getId() === 0) {
            return [];
        }

        return $this
            ->_setAllSectionOperations()
            ->_setSectionOperations()
            ->_setAllBlockOperations()
            ->_setBlockOperations()
            ->_setSettingsOperations()
            ->_cleanUpOperations()
            ->_getOperations();
    }

    /**
     * Sets all section operations
     *
     * @return AbstractGetOperationModel
     */
    private function _setAllSectionOperations()
    {
        $groupOperations = new UserSectionGroupOperationModel();
        $groupOperations->byUserId($this->getId());
        $groupOperations = $groupOperations->findAll();

        if (count($groupOperations) > 0) {
            $this->_operations[Operation::TYPE_SECTIONS][Operation::ALL] = [];
            foreach ($groupOperations as $groupOperation) {
                $this->_operations[Operation::TYPE_SECTIONS][Operation::ALL][]
                    = $groupOperation->get('operation');
            }
        }

        return $this;
    }

    /**
     * Sets section operations
     *
     * @return AbstractGetOperationModel
     */
    private function _setSectionOperations()
    {
        $sectionOperations = new UserSectionOperationModel();
        $sectionOperations->byUserId($this->getId());
        $sectionOperations = $sectionOperations->findAll();

        foreach ($sectionOperations as $sectionOperation) {
            $sectionId = $sectionOperation->get('sectionId');
            $this->_operations[Operation::TYPE_SECTIONS][$sectionId][]
                = $sectionOperation->get('operation');
        }

        return $this;
    }

    /**
     * Sets all blocks operations
     *
     * @return AbstractGetOperationModel
     */
    private function _setAllBlockOperations()
    {
        $blockGroupOperations = new UserBlockGroupOperationModel();
        $blockGroupOperations->byUserId($this->getId());
        $blockGroupOperations = $blockGroupOperations->findAll();
        $all = Operation::ALL;

        foreach ($blockGroupOperations as $blockGroupOperation) {
            $blockType = $blockGroupOperation->get('blockType');

            $hasOperation = array_key_exists(
                $blockType,
                $this->_operations[Operation::TYPE_BLOCKS]
            );
            if ($hasOperation === false) {
                $this->_operations[Operation::TYPE_BLOCKS][$blockType] = [];
            }

            $hasOperation = array_key_exists(
                $all,
                $this->_operations[Operation::TYPE_BLOCKS][$blockType]
            );
            if ($hasOperation === false) {
                $this->_operations[Operation::TYPE_BLOCKS][$blockType][$all]
                    = [];
            }

            $this->_operations[Operation::TYPE_BLOCKS][$blockType][$all][]
                = $blockGroupOperation->get('operation');
        }

        return $this;
    }

    /**
     * Sets blocks operations
     *
     * @return AbstractGetOperationModel
     */
    private function _setBlockOperations()
    {
        $blockOperations = new UserBlockOperationModel();
        $blockOperations->byUserId($this->getId());
        $blockOperations = $blockOperations->findAll();

        foreach ($blockOperations as $blockOperation) {
            $blockType = $blockOperation->get('blockType');

            $hasOperation = array_key_exists(
                $blockType,
                $this->_operations[Operation::TYPE_BLOCKS]
            );
            if ($hasOperation === false) {
                $this->_operations[Operation::TYPE_BLOCKS][$blockType]
                    = [];
            }

            $blockId = $blockOperation->get('blockId');

            $hasOperation = array_key_exists(
                $blockOperation->get('blockId'),
                $this->_operations[Operation::TYPE_BLOCKS][$blockType]
            );
            if ($hasOperation === false) {
                $this->_operations[Operation::TYPE_BLOCKS][$blockType][$blockId]
                    = [];
            }

            $this->_operations[Operation::TYPE_BLOCKS][$blockType][$blockId][]
                = $blockOperation->get('operation');
        }

        return $this;
    }

    /**
     * Sets settings operations
     *
     * @return AbstractGetOperationModel
     */
    private function _setSettingsOperations()
    {
        $settingsOperations = new UserSettingsOperationModel();
        $settingsOperations->byUserId($this->getId());
        $settingsOperations = $settingsOperations->findAll();

        foreach ($settingsOperations as $settingsOperation) {
            $this->_operations[Operation::TYPE_SETTINGS][]
                = $settingsOperation->get('operation');
        }

        return $this;
    }

    /**
     * Cleans up operations
     *
     * @return AbstractGetOperationModel
     */
    private function _cleanUpOperations()
    {
        if (count($this->_operations[Operation::TYPE_BLOCKS]) === 0) {
            unset($this->_operations[Operation::TYPE_BLOCKS]);
        }

        if (count($this->_operations[Operation::TYPE_SECTIONS]) === 0) {
            unset($this->_operations[Operation::TYPE_SECTIONS]);
        }

        if (count($this->_operations[Operation::TYPE_SETTINGS]) === 0) {
            unset($this->_operations[Operation::TYPE_SETTINGS]);
        }

        return $this;
    }

    /**
     * Gets operations
     *
     * @return array
     */
    private function _getOperations()
    {
        return $this->_operations;
    }
}
