<?php

namespace testS\tests\selenium;

use Facebook\WebDriver\WebDriverBy;
use testS\tests\selenium\_abstract\AbstractSeleniumTest;

class Test extends  AbstractSeleniumTest
{


    public function testB()
    {
        $this->clickId('login-button');

        sleep(2);
    }
}
