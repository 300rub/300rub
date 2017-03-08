<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\Language;
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
     * Checks operation
     *
     * @param string $operation
     */
    protected function checkOperation($operation)
    {
        // @TODO
    }

    /**
     * Checks User
     *
     * @throws AccessException
     *
     * @return AbstractController
     */
    protected function checkUser()
    {
        if (!App::web()->getUser() instanceof User) {
            throw new AccessException("Unable to get User");
        }

        return $this;
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