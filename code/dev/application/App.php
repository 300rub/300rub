<?php

namespace ss\application;

use ss\application\instances\_abstract\AbstractApplication;
use ss\application\instances\Console;
use ss\application\instances\Site;
use ss\application\instances\Test;
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
     * Test application
     *
     * @var Test
     */
    private static $_test = null;

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
     * @return Test
     */
    public static function test($config = [])
    {
        if (self::$_test === null) {
            self::$_test = new Test($config);
        }

        return self::$_test;
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
     * @return AbstractApplication
     */
    public static function getInstance()
    {
        if (self::$_web !== null) {
            return self::$_web;
        }

        if (self::$_console !== null) {
            return self::$_console;
        }

        if (self::$_test !== null) {
            return self::$_test;
        }

        if (self::$_site !== null) {
            return self::$_site;
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
