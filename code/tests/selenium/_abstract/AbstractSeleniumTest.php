<?php

namespace ss\tests\selenium\_abstract;

use Facebook\WebDriver\WebDriverBy;
use ss\application\App;

/**
 * Class AbstractSeleniumTest
 */
abstract class AbstractSeleniumTest extends AbstractSeleniumTestCase
{

    /**
     * User types
     *
     * @var array
     */
    private $_userTypes = [
        'user' => [
            'user'     => 'user',
            'password' => 'pass'
        ]
    ];

    /**
     * Gets URL
     *
     * @return string
     */
    protected function getUrl()
    {
        return sprintf(
            'http://selenium.%s',
            App::getInstance()->getConfig()->getValue(['host'])
        );
    }

    /**
     * Opens base URL
     *
     * @return AbstractSeleniumTest
     */
    protected function openBaseUrl()
    {
        $this->driver->get($this->getUrl());
        return $this;
    }

    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->openBaseUrl();
    }

    /**
     * Submits window by name
     *
     * @param string $name Window name
     *
     * @return void
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    protected function submitWindow($name)
    {
        $this->driver
            ->findElement(
                WebDriverBy::cssSelector(
                    sprintf('.window-%s %s', $name, '.footer .submit')
                )
            )
            ->click();
    }

    /**
     * Login user
     *
     * @param string $type User type
     *
     * @return void
     */
    protected function login($type = 'user')
    {
        $this->clickId('login-button');
        $this->fillText(
            '.window-login input[name="user"]',
            $this->_userTypes[$type]['user']
        );
        $this->fillText(
            '.window-login input[name="password"]',
            $this->_userTypes[$type]['password']
        );
        $this->submitWindow('login');
    }
}
