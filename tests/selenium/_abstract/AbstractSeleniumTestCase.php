<?php

namespace ss\tests\selenium\_abstract;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Abstract class to work with selenium tests
 */
class AbstractSeleniumTestCase extends \PHPUnit_Framework_TestCase
{

    const WAIT_TIME = 10;
    const WAIT_INTERVAL = 100;

    /**
     * Web driver
     *
     * @var RemoteWebDriver
     */
    protected $driver = null;

    private function _setWebDriver()
    {
        $this->driver = RemoteWebDriver::create(
            "http://selenium:4444/wd/hub",
            array(
                "platform"    => "WINDOWS",
                "browserName" => "firefox",
                "version"     => "latest"
            )
        );

        return $this;
    }

    public function setUp()
    {
        $this->_setWebDriver();
    }

    public function tearDown()
    {
        $this->driver->quit();
    }

    protected function clickId($cssId)
    {
        if ($this->isVisibleId($cssId) === false) {
            $this->waitId($cssId);
        }

        $this->driver
            ->findElement(WebDriverBy::id($cssId))
            ->click();
    }

    protected function isVisibleId($cssId)
    {
        if (count($this->driver->findElements(WebDriverBy::id($cssId))) === 0) {
            return false;
        }

        return true;
    }

    protected function isVisibleCssSelector($cssSelector)
    {
        if (count($this->driver->findElements(WebDriverBy::cssSelector($cssSelector))) === 0) {
            return false;
        }

        return true;
    }

    protected function waitId($cssId)
    {
        $this->driver->wait(self::WAIT_TIME, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::id($cssId)
            )
        );

        return $this;
    }

    protected function waitCssSelector($cssSelector)
    {
        $this->driver->wait(self::WAIT_TIME, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector($cssSelector)
            )
        );

        return $this;
    }

    protected function fillText($cssSelector, $text)
    {
        if ($this->isVisibleCssSelector($cssSelector) === false) {
            $this->waitCssSelector($cssSelector);
        }

        $this->driver
            ->findElement(WebDriverBy::cssSelector($cssSelector))
            ->click()
            ->clear();
        $this->driver->getKeyboard()->sendKeys($text);
    }

    protected function click($cssSelector)
    {
        if ($this->isVisibleCssSelector($cssSelector) === false) {
            $this->waitCssSelector($cssSelector);
        }

        $this->driver
            ->findElement(WebDriverBy::cssSelector($cssSelector))
            ->click();
    }
}
