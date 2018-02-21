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

    /**
     * Max wait time in seconds
     */
    const WAIT_TIME = 10;

    /**
     * Wait interval in milliseconds
     */
    const WAIT_INTERVAL = 100;

    /**
     * Web driver
     *
     * @var RemoteWebDriver
     */
    protected $driver = null;

    /**
     * Sets web driver
     *
     * @return AbstractSeleniumTestCase
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _setWebDriver()
    {
        $this->driver = RemoteWebDriver::create(
            'http://selenium:4444/wd/hub',
            [
                'platform'    => 'WINDOWS',
                'browserName' => 'firefox',
                'version'     => 'latest'
            ]
        );

        return $this;
    }

    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        $this->_setWebDriver();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown()
    {
        $this->driver->quit();
    }

    /**
     * Click by ID
     *
     * @param string $cssId CSS ID
     *
     * @return void
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function clickId($cssId)
    {
        if ($this->isVisibleId($cssId) === false) {
            $this->waitId($cssId);
        }

        $this->driver
            ->findElement(WebDriverBy::id($cssId))
            ->click();
    }

    /**
     * Is visible by CSS ID
     *
     * @param string $cssId CSS ID
     *
     * @return bool
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function isVisibleId($cssId)
    {
        if (count($this->driver->findElements(WebDriverBy::id($cssId))) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Is visible by CSS selector
     *
     * @param string $cssSelector CSS selector
     *
     * @return bool
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function isVisibleCssSelector($cssSelector)
    {
        $elements = $this->driver->findElements(
            WebDriverBy::cssSelector($cssSelector)
        );

        if (count($elements) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Waits until CSS ID is loaded
     *
     * @param string $cssId CSS ID
     *
     * @return AbstractSeleniumTestCase
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function waitId($cssId)
    {
        $this->driver->wait(self::WAIT_TIME, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::id($cssId)
            )
        );

        return $this;
    }

    /**
     * Waits until CSS selector is loaded
     *
     * @param string $cssSelector CSS selector
     *
     * @return AbstractSeleniumTestCase
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function waitCssSelector($cssSelector)
    {
        $this->driver->wait(self::WAIT_TIME, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector($cssSelector)
            )
        );

        return $this;
    }

    /**
     * Fills text
     *
     * @param string $cssSelector CSS selector
     * @param string $text        Text
     *
     * @return void
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
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

    /**
     * Click on element by CSS selector
     *
     * @param string $cssSelector CSS selector
     *
     * @return void
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
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
