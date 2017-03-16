<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\User;
use testS\components\ValueGenerator;

/**
 * Abstract class for working with controllers
 *
 * @package testS\controllers
 */
abstract class AbstractController
{

    /**
     * Display blocks from page variable name
     */
    const IS_DISPLAY_BLOCKS_FROM_PAGE = "isDisplayBlocksFromPage";

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
            throw new AccessException("User os null");
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
     * If has section operation
     *
     * @param int|string $key
     * @param string     $operation
     *
     * @return bool
     */
    protected function hasSectionOperation($key, $operation)
    {
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
     * Gets flag isDisplayBlocksFromPage
     *
     * @return bool
     */
    protected function getIsDisplayBlocksFromPage()
    {
        $data = $this->getData();
        if (array_key_exists(self::IS_DISPLAY_BLOCKS_FROM_PAGE, $data)) {
            $value = ValueGenerator::generate(
                ValueGenerator::BOOL,
                $data[self::IS_DISPLAY_BLOCKS_FROM_PAGE]
            );
            $_SESSION[self::IS_DISPLAY_BLOCKS_FROM_PAGE] = $value;
            setcookie(self::IS_DISPLAY_BLOCKS_FROM_PAGE, $value);
            return $value;
        }

        if (!empty($_SESSION[self::IS_DISPLAY_BLOCKS_FROM_PAGE])) {
            return ValueGenerator::generate(
                ValueGenerator::BOOL,
                $_SESSION[self::IS_DISPLAY_BLOCKS_FROM_PAGE]
            );
        }

        if (!empty($_COOKIE[self::IS_DISPLAY_BLOCKS_FROM_PAGE])) {
            $value = ValueGenerator::generate(
                ValueGenerator::BOOL,
                $_COOKIE[self::IS_DISPLAY_BLOCKS_FROM_PAGE]
            );
            $_SESSION[self::IS_DISPLAY_BLOCKS_FROM_PAGE] = $value;
            return $value;
        }

        return false;
    }

    /**
     * Gets sectionId from Request
     *
     * @return int
     *
     * @throws BadRequestException
     */
    protected function getSectionIdFromRequest()
    {
        $data = $this->getData();
        if (!array_key_exists("sectionId", $data)) {
            throw new BadRequestException(
                "Incorrect request for getting blocks from page. Unable to find [sectionId] in request.",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $sectionId = (int) $data["sectionId"];
        if ($sectionId <= 0) {
            throw new BadRequestException(
                "Incorrect request for getting blocks from. [sectionId] is incorrect.",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        return $sectionId;
    }

    /**
     * Gets language from Request
     *
     * @return int
     *
     * @throws BadRequestException
     */
    protected function getLanguageFromRequest()
    {
        $data = $this->getData();
        if (!array_key_exists("language", $data)) {
            throw new BadRequestException(
                "Incorrect request. Unable to find [language] in request.",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $language = (int) $data["language"];
        if (!array_key_exists($language, Language::$aliasList)) {
            throw new BadRequestException(
                "Incorrect request. [language] is incorrect.",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        return $language;
    }
}