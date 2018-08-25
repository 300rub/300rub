<?php

namespace ss\models\user\_abstract;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserBlockGroupOperationModel;
use ss\models\user\UserBlockOperationModel;
use ss\models\user\UserSectionGroupOperationModel;
use ss\models\user\UserSectionOperationModel;
use ss\models\user\UserSessionModel;
use ss\models\user\UserSettingsOperationModel;

/**
 * Abstract model to get user operations
 */
abstract class AbstractSaveOperationModel extends AbstractGetOperationModel
{

    /**
     * Adds operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    public function addOperations(array $operations)
    {
        $this
            ->_addSectionOperations($operations)
            ->_addBlockOperations($operations)
            ->_addSettingsOperations($operations);

        return $this;
    }

    /**
     * Adds section operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _addSectionOperations(array $operations)
    {
        if (array_key_exists(Operation::TYPE_SECTIONS, $operations) === false
            || is_array($operations[Operation::TYPE_SECTIONS]) === false
        ) {
            return $this;
        }

        $this
            ->_saveAllSectionOperations($operations)
            ->_saveSectionOperations($operations);

        return $this;
    }

    /**
     * Adds all section operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _saveAllSectionOperations(array $operations)
    {
        $operation = App::getInstance()->getOperation();

        foreach (array_keys($operations[Operation::TYPE_SECTIONS]) as $key) {
            if ($key !== Operation::ALL) {
                continue;
            }

            $isArray = is_array(
                $operations[Operation::TYPE_SECTIONS][$key]
            );
            if ($isArray === false) {
                continue;
            }

            $sectionOperations = $operations[Operation::TYPE_SECTIONS][$key];
            foreach ($sectionOperations as $operationKey => $operationValue) {
                $hasOperation = array_key_exists(
                    $operationKey,
                    $operation->getSectionOperations(true)
                );
                if ($hasOperation === false
                    || $operationValue === false
                ) {
                    continue;
                }

                $model = new UserSectionGroupOperationModel();
                $model->set(
                    [
                        'userId' => $this->getId(),
                        'operation' => $operationKey
                    ]
                );
                $model->save();
            }
        }

        return $this;
    }

    /**
     * Adds section operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _saveSectionOperations(array $operations)
    {
        $operation = App::getInstance()->getOperation();

        foreach (array_keys($operations[Operation::TYPE_SECTIONS]) as $key) {
            if ($key === Operation::ALL) {
                continue;
            }

            $isArray = is_array($operations[Operation::TYPE_SECTIONS][$key]);
            if ($isArray === false) {
                continue;
            }

            $sectionOperations = $operations[Operation::TYPE_SECTIONS][$key];
            foreach ($sectionOperations as $operationKey => $operationValue) {
                $hasOperation = array_key_exists(
                    $operationKey,
                    $operation->getSectionOperations(false)
                );
                if ($hasOperation === false
                    || $operationValue === false
                ) {
                    continue;
                }

                $model = new UserSectionOperationModel();
                $model->set(
                    [
                        'userId' => $this->getId(),
                        'sectionId' => $key,
                        'operation' => $operationKey
                    ]
                );
                $model->save();
            }
        }

        return $this;
    }

    /**
     * Adds block operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _addBlockOperations(array $operations)
    {
        if (array_key_exists(Operation::TYPE_BLOCKS, $operations) === false
            || is_array($operations[Operation::TYPE_BLOCKS]) === false
        ) {
            return $this;
        }

        $blockOperations = $operations[Operation::TYPE_BLOCKS];
        foreach ($blockOperations as $blockType => $blockTypeValues) {
            if (array_key_exists($blockType, BlockModel::$typeList) === false
                || is_array($blockTypeValues) === false
            ) {
                continue;
            }

            $this
                ->_saveAllBlockOperations($blockType, $blockTypeValues)
                ->_saveBlockOperations($blockType, $blockTypeValues);
        }

        return $this;
    }

    /**
     * Adds all block operations
     *
     * @param string $blockType       Block type
     * @param array  $blockTypeValues Block type values
     *
     * @return AbstractSaveOperationModel
     */
    private function _saveAllBlockOperations($blockType, $blockTypeValues)
    {
        $allContentOperations = App::getInstance()
            ->getOperation()
            ->getOperationsByContentType($blockType, true);

        foreach (array_keys($blockTypeValues) as $key) {
            if ($key !== Operation::ALL
                || is_array($blockTypeValues[$key]) === false
            ) {
                continue;
            }

            foreach ($blockTypeValues[$key] as $operationKey => $value) {
                $hasKey = array_key_exists(
                    $operationKey,
                    $allContentOperations
                );
                if ($hasKey === false
                    || $value === false
                ) {
                    continue;
                }

                $model = new UserBlockGroupOperationModel();
                $model->set(
                    [
                        'userId'    => $this->getId(),
                        'blockType' => $blockType,
                        'operation' => $operationKey
                    ]
                );
                $model->save();
            }
        }

        return $this;
    }

    /**
     * Adds block operations
     *
     * @param string $blockType       Block type
     * @param array  $blockTypeValues Block type values
     *
     * @return AbstractSaveOperationModel
     */
    private function _saveBlockOperations($blockType, $blockTypeValues)
    {
        $contentOperations = App::getInstance()
            ->getOperation()
            ->getOperationsByContentType($blockType, false);

        foreach (array_keys($blockTypeValues) as $key) {
            if ($key === Operation::ALL
                || is_array($blockTypeValues[$key]) === false
            ) {
                continue;
            }

            foreach ($blockTypeValues[$key] as $operationKey => $value) {
                $hasKey = array_key_exists(
                    $operationKey,
                    $contentOperations
                );
                if ($hasKey === false
                    || $value === false
                ) {
                    continue;
                }

                $model = new UserBlockOperationModel();
                $model->set(
                    [
                        'userId'    => $this->getId(),
                        'blockType' => $blockType,
                        'blockId'   => $key,
                        'operation' => $operationKey
                    ]
                );
                $model->save();
            }
        }

        return $this;
    }

    /**
     * Adds settings operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _addSettingsOperations(array $operations)
    {
        if (array_key_exists(Operation::TYPE_SETTINGS, $operations) === false
            || is_array($operations[Operation::TYPE_SETTINGS]) === false
        ) {
            return $this;
        }

        $this->_saveSettingsOperations($operations);

        return $this;
    }

    /**
     * Adds settings operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _saveSettingsOperations(array $operations)
    {
        $settingsOperations = $operations[Operation::TYPE_SETTINGS];
        foreach ($settingsOperations as $operationKey => $operationValue) {
            $hasOperation = array_key_exists(
                $operationKey,
                App::getInstance()->getOperation()->getSettingsOperations()
            );
            if ($hasOperation === false
                || $operationValue === false
            ) {
                continue;
            }

            $model = new UserSettingsOperationModel();
            $model->set(
                [
                    'userId'    => $this->getId(),
                    'operation' => $operationKey
                ]
            );
            $model->save();
        }

        return $this;
    }

    /**
     * Updates operations
     *
     * @param array $operations Operations
     *
     * @return AbstractSaveOperationModel
     */
    public function updateOperations(array $operations)
    {
        $this
            ->_deleteOperations()
            ->addOperations($operations);
        return $this;
    }

    /**
     * Deletes operations
     *
     * @return AbstractSaveOperationModel
     */
    private function _deleteOperations()
    {
        $blockGroup = new UserBlockGroupOperationModel();
        $blockGroup->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $blockOperation = new UserBlockOperationModel();
        $blockOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $sectionGroup = new UserSectionGroupOperationModel();
        $sectionGroup->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $sectionOperation = new UserSectionOperationModel();
        $sectionOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $settingsOperation = new UserSettingsOperationModel();
        $settingsOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        return $this;
    }
}
