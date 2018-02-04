<?php

namespace testS\tests\selenium\_abstract;

use Facebook\WebDriver\WebDriverBy;

class AbstractSeleniumTest extends AbstractSeleniumTestCase
{

    private $userTypes = [
        'user' => [
            'user'     => 'user',
            'password' => 'pass'
        ]
    ];

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
        return $this;
    }

    public function setUp()
    {
        parent::setUp();

        $this
            ->resetDb()
            ->openBaseUrl();
    }

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

    protected function login($type = 'user')
    {
        $this->clickId('login-button');
        $this->fillText('.window-login input[name="user"]', $this->userTypes[$type]['user']);
        $this->fillText('.window-login input[name="password"]', $this->userTypes[$type]['password']);
        $this->submitWindow('login');
    }
}
