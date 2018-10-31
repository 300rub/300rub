<?php

namespace ss\controllers\_abstract;

use ss\application\components\user\Operation;
use ss\application\exceptions\AccessException;

/**
 * Abstract class for working with user operations
 */
abstract class AbstractOperationController extends AbstractUserController
{

    /**
     * If has section operation
     *
     * @param int|string $key       Operation key
     * @param string     $operation Operation name
     *
     * @return bool
     */
    protected function hasSectionOperation($key, $operation)
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        $operations = $this->getUserOperations();
        if (array_key_exists(Operation::TYPE_SECTIONS, $operations) === false) {
            return false;
        }

        $hasAll = array_key_exists(
            Operation::ALL,
            $operations[Operation::TYPE_SECTIONS]
        );
        if ($hasAll === true) {
            $hasOperation = in_array(
                $operation,
                $operations[Operation::TYPE_SECTIONS][Operation::ALL]
            );

            if ($hasOperation === true) {
                return true;
            }
        }

        $hasKey = array_key_exists(
            $key,
            $operations[Operation::TYPE_SECTIONS]
        );
        if ($hasKey === true) {
            $hasOperation = in_array(
                $operation,
                $operations[Operation::TYPE_SECTIONS][$hasKey]
            );

            if ($hasOperation === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Has any Section operations
     *
     * @return bool
     */
    protected function hasAnySectionOperations()
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        $hasSections = array_key_exists(
            Operation::TYPE_SECTIONS,
            $this->getUserOperations()
        );

        return $hasSections === true;
    }

    /**
     * If has block operation
     *
     * @param int        $type      Block type
     * @param int|string $key       Operation key
     * @param string     $operation Operation name
     *
     * @return bool
     */
    protected function hasBlockOperation($type, $key = null, $operation = null)
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        if ($this->_hasAnyBlockTypeOperations($type) === false) {
            return false;
        }

        $operations = $this->getUserOperations();

        if ($key === null) {
            return true;
        }

        $hasAll = array_key_exists(
            Operation::ALL,
            $operations[Operation::TYPE_BLOCKS][$type]
        );
        if ($hasAll === true) {
            $hasOperation = in_array(
                $operation,
                $operations[Operation::TYPE_BLOCKS][$type][Operation::ALL]
            );

            if ($hasOperation === true) {
                return true;
            }
        }

        $hasKey = array_key_exists(
            $key,
            $operations[Operation::TYPE_BLOCKS][$type]
        );
        if ($hasKey === true) {
            $hasOperation = in_array(
                $operation,
                $operations[Operation::TYPE_BLOCKS][$type][$hasKey]
            );

            if ($hasOperation === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks any operation for block type
     *
     * @param string $type Block type
     *
     * @return bool
     */
    private function _hasAnyBlockTypeOperations($type)
    {
        $operations = $this->getUserOperations();

        $hasBlocks = array_key_exists(
            Operation::TYPE_BLOCKS,
            $operations
        );
        if ($hasBlocks === false) {
            return false;
        }

        $hasType = array_key_exists(
            $type,
            $operations[Operation::TYPE_BLOCKS]
        );
        if ($hasType === false) {
            return false;
        }

        return true;
    }

    /**
     * Has any Block operations
     *
     * @return bool
     */
    protected function hasAnyBlockOperations()
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        $hasBlocks = array_key_exists(
            Operation::TYPE_BLOCKS,
            $this->getUserOperations()
        );

        return $hasBlocks === true;
    }

    /**
     * Has settings operation
     *
     * @param string $operation Operation name
     *
     * @return bool
     */
    protected function hasSettingsOperation($operation)
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        $operations = $this->getUserOperations();

        if (array_key_exists(Operation::TYPE_SETTINGS, $operations) === false) {
            return false;
        }

        $hasSettings = in_array(
            $operation,
            $operations[Operation::TYPE_SETTINGS]
        );

        return $hasSettings === true;
    }

    /**
     * Checks settings operation
     *
     * @param string $operation Operation name
     *
     * @return AbstractOperationController
     *
     * @throws AccessException
     */
    protected function checkSettingsOperation($operation = null)
    {
        if ($this->hasSettingsOperation($operation) === false) {
            throw new AccessException(
                'Access denied for settings operation: {operation}',
                [
                    'operation' => $operation
                ]
            );
        }

        return $this;
    }

    /**
     * Checks block operation
     *
     * @param int        $type      Block type
     * @param int|string $key       Operation key
     * @param string     $operation Operation name
     *
     * @return AbstractOperationController
     *
     * @throws AccessException
     */
    protected function checkBlockOperation($type, $key, $operation)
    {
        if ($this->hasBlockOperation($type, $key, $operation) === false) {
            throw new AccessException(
                'Access denied for block operation: ' .
                '{operation}, type: {type}, key: {key}',
                [
                    'operation' => $operation,
                    'type'      => $type,
                    'key'       => $key,
                ]
            );
        }

        return $this;
    }

    /**
     * Checks section operation
     *
     * @param string $operation Operation name
     *
     * @return AbstractOperationController
     *
     * @throws AccessException
     */
    protected function checkSectionOperation($operation = null)
    {
        $result = false;

        if ($operation === null) {
            $result = $this->hasAnySectionOperations();
        }

        if ($operation !== null) {
            $result = $this->hasSettingsOperation($operation);
        }

        if ($result === false) {
            throw new AccessException(
                'Access denied for settings operation: {operation}',
                [
                    'operation' => $operation
                ]
            );
        }

        return $this;
    }
}
