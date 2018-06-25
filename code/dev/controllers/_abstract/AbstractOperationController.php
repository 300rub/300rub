<?php

namespace ss\controllers\_abstract;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\components\User;
use ss\application\exceptions\AccessException;
use ss\models\user\UserModel;

/**
 * Abstract class for working with user operations
 */
abstract class AbstractOperationController extends AbstractDataController
{

    /**
     * Flag is user
     *
     * @return bool
     */
    protected function isUser()
    {
        $user = App::web()->getUser();
        return $user instanceof User;
    }

    /**
     * Checks user
     *
     * @return AbstractOperationController
     *
     * @throws AccessException
     */
    protected function checkUser()
    {
        if ($this->isUser() === false) {
            throw new AccessException('User is null');
        }

        if (App::web()->getUser()->getType() === UserModel::TYPE_BLOCKED) {
            throw new AccessException('User is blocked');
        }

        return $this;
    }

    /**
     * Gets user operations
     *
     * @return array
     */
    protected function getUserOperations()
    {
        $user = App::web()->getUser();
        if ($user instanceof User === false) {
            return [];
        }

        return App::web()->getUser()->getOperations();
    }

    /**
     * Gets user flag is full access
     *
     * @return bool
     */
    protected function isFullAccess()
    {
        $user = App::web()->getUser();
        if ($user instanceof User === false) {
            return false;
        }

        if ($user->getType() === UserModel::TYPE_OWNER
            || $user->getType() === UserModel::TYPE_FULL
        ) {
            return true;
        }

        return false;
    }

    /**
     * Gets user flag is blocked
     *
     * @return bool
     */
    protected function isBlocked()
    {
        $user = App::web()->getUser();
        if ($user instanceof User === false) {
            return true;
        }

        return $user->getType() === UserModel::TYPE_BLOCKED;
    }

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
    protected function checkSettingsOperation($operation)
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
}
