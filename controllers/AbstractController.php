<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\Operation;
use testS\components\User;
use testS\models\UserModel;

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
    protected function hasBlockOperation($type, $key, $operation)
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
     * Checks settings operatio
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
            setcookie(self::DISPLAY_BLOCKS_FROM_SECTION, $value, time() + 86400 * 365 * 10, "/"); // 10 years
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
		$path = $this->_getViewsRootDir() . $viewFile . ".php";

		extract($data, EXTR_OVERWRITE);

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

    /**
     * Gets path to views root dir
     *
     * @return string
     */
	private function _getViewsRootDir()
	{
		return __DIR__ . "/../views/";
	}
}