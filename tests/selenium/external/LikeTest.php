<?php

namespace ss\tests\selenium\external;

use ss\tests\selenium\_abstract\AbstractSeleniumTestCase;

/**
 * Class LikeTest
 */
class LikeTest extends AbstractSeleniumTestCase
{

    /**
     * Like test
     *
     * @return void
     */
    public function testLike()
    {
        $this->driver->get('https://vk.com/');
        $this->fillText(
            '#index_login_form input[name="email"]',
            '447894241250'
        );
        $this->fillText(
            '#index_login_form input[name="pass"]',
            'vk1pasS77'
        );
        $this->click('#index_login_form #index_login_button');
        $this->waitCssSelector('.top_profile_name');
        $this->driver->get('https://olike.ru/');

        $this->driver->executeScript(
            '$("img[data-uloginbutton=\"vkontakte\"]").click()'
        );

        for ($i = 1; $i < 47; $i++) {
            $this->click('.universalButton_dash.purpleButton');
            sleep(1);
            $handles = $this->driver->getWindowHandles();
            $this->driver->switchTo()->window(end($handles));

            $script = '
                var button = document.getElementById("public_subscribe");
                if (!!button) {
                    button.click();
                } else {
                    button = document.getElementById("join_button");
                    if (!!button) {
                        button.click();
                    }
                }
            ';
            $this->driver->executeScript($script);
            sleep(2);

            $this->driver->executeScript('window.close();');
            sleep(2);

            $this->driver->switchTo()->window($handles[0]);
        }

        sleep(5);
    }
}
