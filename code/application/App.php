<?php

namespace ss\application;

use ss\application\instances\_abstract\AbstractApplication;
use ss\application\instances\Console;
use ss\application\instances\Phpunit;
use ss\application\instances\Selenium;
use ss\application\instances\Site;
use ss\application\instances\Web;

/**
 * Class for running application
 */
class App
{

    /**
     * Class map
     *
     * @var string[]
     */
    public static $classMap = [];

    /**
     * Console application
     *
     * @var Console
     */
    private static $_console = null;

    /**
     * Web application
     *
     * @var Web
     */
    private static $_web = null;

    /**
     * Phpunit application
     *
     * @var Phpunit
     */
    private static $_phpunit = null;

    /**
     * Selenium application
     *
     * @var Selenium
     */
    private static $_selenium = null;

    /**
     * Site application
     *
     * @var Web
     */
    private static $_site = null;

    /**
     * Gets application for working with console
     *
     * @param array $config Config settings
     *
     * @return Console
     */
    public static function console($config = [])
    {
        if (self::$_console === null) {
            self::$_console = new Console($config);
        }

        return self::$_console;
    }

    /**
     * Gets Application for working with web
     *
     * @param array $config Config settings
     *
     * @return Web
     */
    public static function web($config = [])
    {
        if (self::$_web === null) {
            self::$_web = new Web($config);
        }

        return self::$_web;
    }

    /**
     * Gets application for working with tests
     *
     * @param array $config Config settings
     *
     * @return Phpunit
     */
    public static function phpunit($config = [])
    {
        if (self::$_phpunit === null) {
            self::$_phpunit = new Phpunit($config);
        }

        return self::$_phpunit;
    }

    /**
     * Gets application for working with selenium
     *
     * @param array $config Config settings
     *
     * @return Phpunit
     */
    public static function selenium($config = [])
    {
        if (self::$_selenium === null) {
            self::$_selenium = new Selenium($config);
        }

        return self::$_selenium;
    }

    /**
     * Gets Application for working with site
     *
     * @param array $config Config settings
     *
     * @return Web
     */
    public static function site($config = [])
    {
        if (self::$_site === null) {
            self::$_site = new Site($config);
        }

        return self::$_site;
    }

    /**
     * Gets current application
     *
     * @return AbstractApplication|Web|Site
     */
    public static function getInstance()
    {
        if (self::$_web !== null) {
            return self::$_web;
        }

        if (self::$_site !== null) {
            return self::$_site;
        }

        if (self::$_phpunit !== null) {
            return self::$_phpunit;
        }

        if (self::$_selenium !== null) {
            return self::$_selenium;
        }

        if (self::$_console !== null) {
            return self::$_console;
        }

        return null;
    }

    /**
     * Autoload for all classes
     *
     * @param string $className Class name
     *
     * @return bool
     */
    public static function autoload($className)
    {
        if (in_array($className, self::$classMap) === true) {
            return false;
        }

        $filePath = __DIR__ .
            '/../' .
            str_replace(
                '\\',
                '/',
                str_replace(
                    'ss\\',
                    '',
                    $className
                )
            )  .
            '.php';
        if (file_exists($filePath) === true) {
            include_once $filePath;
        }

        self::$classMap[] = $className;

        return true;
    }
}
