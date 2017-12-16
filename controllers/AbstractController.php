<?php

namespace testS\controllers;

use testS\application\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\Operation;
use testS\components\User;
use testS\components\View;
use testS\models\UserModel;
use testS\components\Db;

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
     * Form types
     */
    const FORM_TYPE_TEXT = "text";
    const FORM_TYPE_PASSWORD = "password";
    const FORM_TYPE_CHECKBOX = "checkbox";
    const FORM_TYPE_BUTTON = "button";
    const FORM_TYPE_SELECT = "select";

    // Check data constants
    const TYPE_INT = "int";
    const TYPE_ARRAY = "array";
    const TYPE_BOOL = "bool";
    const TYPE_STRING = "string";
    const NOT_EMPTY = "notEmpty";

    /**
     * Request data
     *
     * @var array
     */
    private $_data = [];

    /**
     * Gets simple success result
     *
     * @return array
     */
    protected function getSimpleSuccessResult()
    {
        return [
            "result" => true
        ];
    }

    /**
     * Gets data
     *
     * @param string
     *
     * @return mixed
     */
    protected function get($key)
    {
        if (!array_key_exists($key, $this->_data)) {
            return null;
        }

        return $this->_data[$key];
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
     * @return AbstractController
     *
     * @throws AccessException
     */
    protected function checkUser()
    {
        if (!$this->isUser()) {
            throw new AccessException("User is null");
        }

        if (App::web()->getUser()->getType() === UserModel::TYPE_BLOCKED) {
            throw new AccessException("User is blocked");
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
     * Gets user flag is full access
     *
     * @return bool
     */
    protected function isFullAccess()
    {
        $user = App::web()->getUser();
        if (!$user instanceof User) {
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
        if (!$user instanceof User) {
            return true;
        }

        return $user->getType() === UserModel::TYPE_BLOCKED;
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
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
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

        return array_key_exists(Operation::TYPE_SECTIONS, $this->getUserOperations());
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
    protected function hasBlockOperation($type, $key = null, $operation = null)
    {
        if ($this->isFullAccess() === true) {
            return true;
        }

        if ($this->isBlocked() === true) {
            return false;
        }

        $operations = $this->getUserOperations();
        if (!array_key_exists(Operation::TYPE_BLOCKS, $operations)
            || !array_key_exists($type, $operations[Operation::TYPE_BLOCKS])
        ) {
            return false;
        }

        if ($key === null) {
            return true;
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

        return array_key_exists(Operation::TYPE_BLOCKS, $this->getUserOperations());
    }

    /**
     * Has settings operation
     *
     * @param string $operation
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

        if (!array_key_exists(Operation::TYPE_SETTINGS, $operations)) {
            return false;
        }

        return in_array($operation, $operations[Operation::TYPE_SETTINGS]);
    }

    /**
     * Checks settings operation
     *
     * @param string $operation
     *
     * @return AbstractController
     *
     * @throws AccessException
     */
    protected function checkSettingsOperation($operation)
    {
        if (!$this->hasSettingsOperation($operation)) {
            throw new AccessException(
                "Access denied for settings operation: {operation}",
                [
                    "operation" => $operation
                ]
            );
        }

        return $this;
    }

    /**
     * Checks block operation
     *
     * @param int        $type
     * @param int|string $key
     * @param string     $operation
     *
     * @return AbstractController
     *
     * @throws AccessException
     */
    protected function checkBlockOperation($type, $key, $operation)
    {
        if (!$this->hasBlockOperation($type, $key, $operation)) {
            throw new AccessException(
                "Access denied for block operation: {operation}, type: {type}, key: {key}",
                [
                    "operation" => $operation,
                    "type"      => $type,
                    "key"       => $key,
                ]
            );
        }

        return $this;
    }

    /**
     * Gets displayBlocksFromPage
     *
     * @return int
     */
    protected function getDisplayBlocksFromSection()
    {
        if ($this->get(self::DISPLAY_BLOCKS_FROM_SECTION) !== null) {
            $value = (int) $this->get(self::DISPLAY_BLOCKS_FROM_SECTION);
            $_SESSION[self::DISPLAY_BLOCKS_FROM_SECTION] = $value;
            setcookie(self::DISPLAY_BLOCKS_FROM_SECTION, $value, time() + 86400 * 365 * 10, "/");
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

    /**
     * Gets content from view
     *
     * @param string $viewFile View file
     * @param array  $data     Data
     *
     * @return string
     */
	protected function getContentFromTemplate($viewFile, $data = [])
	{
		return View::get($viewFile, $data);
	}

    /**
     * Removes saved data
     */
    protected function removeSavedData()
    {
        Db::rollbackTransaction();
        Db::startTransaction();
    }

    /**
     * Checks the data
     *
     * @param array $check
     *
     * @throws BadRequestException
     *
     * @return AbstractController
     */
    protected function checkData(array $check)
    {
        foreach ($check as $field => $options) {
            if (!is_array($options)) {
                $field = $options;
                $options = [];
            }

            if (!array_key_exists($field, $this->_data)) {
                throw new BadRequestException(
                    "Unable to find {field} in request",
                    [
                        "field" => $field
                    ]
                );
            }

            $value = $this->get($field);

            if (in_array(self::TYPE_INT, $options)
                && !is_int($value)
            ) {
                throw new BadRequestException(
                    "The field type of {field} is not integer",
                    [
                        "field" => $field
                    ]
                );
            }

            if (in_array(self::TYPE_STRING, $options)
                && !is_string($value)
            ) {
                throw new BadRequestException(
                    "The field type of {field} is not string",
                    [
                        "field" => $field
                    ]
                );
            }

            if (in_array(self::TYPE_BOOL, $options)
                && !is_bool($value)
            ) {
                throw new BadRequestException(
                    "The field type of {field} is not bool",
                    [
                        "field" => $field
                    ]
                );
            }

            if (in_array(self::TYPE_ARRAY, $options)
                && !is_array($value)
            ) {
                throw new BadRequestException(
                    "The field {field} is not an array",
                    [
                        "field" => $field
                    ]
                );
            }

            if (in_array(self::NOT_EMPTY, $options)
                && empty($value)
            ) {
                throw new BadRequestException(
                    "The field {field} can not be empty",
                    [
                        "field" => $field
                    ]
                );
            }
        }

        return $this;
    }
}