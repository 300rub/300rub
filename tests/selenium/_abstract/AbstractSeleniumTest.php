<?php

namespace testS\tests\selenium\_abstract;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Abstract class to work with selenium tests
 */
class AbstractSeleniumTest extends  \PHPUnit_Framework_TestCase
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

    protected function getUrl()
    {
        return sprintf("http://172.17.0.1:800%s", getenv('TEST_TOKEN') + 1);
    }

    protected function resetDb()
    {
        $this->driver->get(sprintf('%s/reset.php', $this->getUrl()));
        $this->waitId('ok');

        return $this;
    }

    protected function openBaseUrl()
    {
        $this->driver->get($this->getUrl());
        sleep(3);
        return $this;
    }

    public function setUp()
    {
        $this
            ->_setWebDriver()
            ->resetDb()
            ->openBaseUrl();
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

    protected function waitId($cssId)
    {
        $this->driver->wait(self::WAIT_TIME, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::id($cssId)
            )
        );

        return $this;
    }
}
