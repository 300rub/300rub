<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\Operation;
use testS\components\User;

/**
 * Abstract class for working with controllers
 *
 * @package testS\controllers
 */
abstract class AbstractController
{

    /**
     * Display blocks from section variable name
     */
    const DISPLAY_BLOCKS_FROM_SECTION = "displayBlocksFromSection";

    /**
     * Request data
     *
     * @var array
     */
    private $_data = [];

    /**
     * Gets data
     *
     * @return array
     */
    protected function getData()
    {
        return $this->_data;
    }

    /**
     * Sets data
     *
     * @param array $data
     *
     * @return AbstractController
     */
    public function setData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * Checks user
     *
     * @return AbstractController
     *
     * @throws AccessException
     */
    protected function checkUser()
    {
        $user = App::web()->getUser();
        if (!$user instanceof User) {
            throw new AccessException("User is null");
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
        if (!$user instanceof User) {
            return [];
        }
        return App::web()->getUser()->getOperations();
    }

    /**
     * Gets user flag is owner
     *
     * @return bool
     */
    protected function getUserIsOwner()
    {
        $user = App::web()->getUser();
        if (!$user instanceof User) {
            return false;
        }
        return App::web()->getUser()->getIsOwner();
    }

    /**
     * If has section operation
     *
     * @param int|string $key
     * @param string     $operation
     *
     * @return bool
     */
    protected function hasSectionOperation($key, $operation)
    {
        if ($this->getUserIsOwner() === true) {
            return true;
        }

        $operations = $this->getUserOperations();
        if (!array_key_exists(Operation::TYPE_SECTIONS, $operations)) {
            return false;
        }

        if (array_key_exists(Operation::ALL, $operations[Operation::TYPE_SECTIONS])
            && in_array($operation, $operations[Operation::TYPE_SECTIONS][Operation::ALL])
        ) {
            return true;
        }

        if (array_key_exists($key, $operations[Operation::TYPE_SECTIONS])
            && in_array($operation, $operations[Operation::TYPE_SECTIONS][$key])
        ) {
            return true;
        }

        return false;
    }

    /**
     * If has block operation
     *
     * @param int        $type
     * @param int|string $key
     * @param string     $operation
     *
     * @return bool
     */
    protected function hasBlockOperation($type, $key, $operation)
    {
        if ($this->getUserIsOwner() === true) {
            return true;
        }

        $operations = $this->getUserOperations();
        if (!array_key_exists(Operation::TYPE_BLOCKS, $operations)
            || !array_key_exists($type, $operations[Operation::TYPE_BLOCKS])
        ) {
            return false;
        }

        if (array_key_exists(Operation::ALL, $operations[Operation::TYPE_BLOCKS][$type])
            && in_array($operation, $operations[Operation::TYPE_BLOCKS][$type][Operation::ALL])
        ) {
            return true;
        }

        if (array_key_exists($key, $operations[Operation::TYPE_BLOCKS][$type])
            && in_array($operation, $operations[Operation::TYPE_BLOCKS][$type][$key])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Gets displayBlocksFromPage
     *
     * @return int
     */
    protected function getDisplayBlocksFromSection()
    {
        $data = $this->getData();
        if (array_key_exists(self::DISPLAY_BLOCKS_FROM_SECTION, $data)) {
            $value = (int) $data[self::DISPLAY_BLOCKS_FROM_SECTION];
            $_SESSION[self::DISPLAY_BLOCKS_FROM_SECTION] = $value;
            setcookie(self::DISPLAY_BLOCKS_FROM_SECTION, $value);
            return $value;
        }

        if (!empty($_SESSION[self::DISPLAY_BLOCKS_FROM_SECTION])) {
            return (int) $_SESSION[self::DISPLAY_BLOCKS_FROM_SECTION];
        }

        if (!empty($_COOKIE[self::DISPLAY_BLOCKS_FROM_SECTION])) {
            $value = (int) $_COOKIE[self::DISPLAY_BLOCKS_FROM_SECTION];
            $_SESSION[self::DISPLAY_BLOCKS_FROM_SECTION] = $value;
            return $value;
        }

        return 0;
    }
}