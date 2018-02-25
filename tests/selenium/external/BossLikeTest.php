<?php

namespace ss\tests\selenium\external;

use Facebook\WebDriver\WebDriverBy;
use ss\tests\selenium\_abstract\AbstractSeleniumTestCase;

/**
 * Class LikeTest
 */
class BossLikeTest extends AbstractSeleniumTestCase
{

    /**
     * User and pass constants
     */
    const VK_USER = 'vkUser';
    const VK_PASS = 'vkPass';
    const BL_USER = 'blUser';
    const BL_PASS = 'blPass';

    /**
     * VK group link
     */
    const VK_GROUP = 'https://vk.com/supers_vk';

    /**
     * Price
     */
    const TASK_PRICE = 18;

    /**
     * Loop count
     */
    const LOOP_COUNT = 50;

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            '447894241250' => [
                'vkUser' => '447894241250',
                'vkPass' => 'vk1pasS77',
                'blUser' => 'vk447894241250@yandex.ru',
                'blPass' => 'pass447894241250',
            ],
        ];
    }

    /**
     * Like test
     *
     * @param string $vkUser VK user
     * @param string $vkPass VK pass
     * @param string $blUser BossLike user
     * @param string $blPass BossLike pass
     *
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testLike($vkUser, $vkPass, $blUser, $blPass)
    {
        $this
            ->_vkLogin($vkUser, $vkPass)
            ->_bossLikeLogin($blUser, $blPass)
            ->_addLikes()
            ->_addTask();
    }

    /**
     * VK Login
     *
     * @param string $vkUser VK user
     * @param string $vkPass VK pass
     *
     * @return BossLikeTest
     */
    private function _vkLogin($vkUser, $vkPass)
    {
        $this->driver->get('https://vk.com/');

        $this->fillText(
            '#index_login_form input[name="email"]',
            $vkUser
        );

        $this->fillText(
            '#index_login_form input[name="pass"]',
            $vkPass
        );

        $this->click('#index_login_form #index_login_button');
        $this->waitCssSelector('.top_profile_name');

        return $this;
    }

    /**
     * Boss like Login
     *
     * @param string $blUser BossLike user
     * @param string $blPass BossLike pass
     *
     * @return BossLikeTest
     */
    private function _bossLikeLogin($blUser, $blPass)
    {
        $this->driver->get('http://bosslike.ru/login/');

        $this->fillText(
            '#User_loginLogin',
            $blUser
        );

        $this->fillText(
            '#User_passwordLogin',
            $blPass
        );

        $this->click('.form-group .btn-block');

        return $this;
    }

    /**
     * Adds likes
     *
     * @return BossLikeTest
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _addLikes()
    {
        $latestLinkText = '';

        for ($i = 0; $i < self::LOOP_COUNT; $i++) {
            $this->driver->get('http://bosslike.ru/tasks/vkontakte/subscribe/');

            try {
                sleep(1);

                $panelBodies = $this->findAll('.panel-body');
                $trash = null;
                foreach ($panelBodies as $panelBody) {
                    $body = $panelBody->findElement(
                        WebDriverBy::cssSelector('.task-body h2 .do-task')
                    );
                    $trash = $panelBody->findElement(
                        WebDriverBy::cssSelector('.fa-trash')
                    );

                    $text = $body->getText();
                    if ($text !== $latestLinkText
                        && mb_strpos($text, 'Вступить в группу') !== false
                        || (mb_strpos($text, 'Подписаться') !== false
                        && mb_strpos($text, 'на страницу') !== false)
                    ) {
                        $latestLinkText = $text;
                        $body->click();
                        break;
                    }

                    $trash->click();
                }

                sleep(1);

                $handles = $this->driver->getWindowHandles();
                if (count($handles) === 1) {
                    if ($trash !== null) {
                        $trash->click();
                    }
                    sleep(2);
                    continue;
                }

                $this->driver->switchTo()->window(end($handles));
                $this->waitId('page_body');

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
            } catch (\Exception $e) {
                continue;
            }
        }

        return $this;
    }

    /**
     * Adds task
     *
     * @return BossLikeTest
     */
    private function _addTask()
    {
        $this->driver->get('http://bosslike.ru/tasks/my/');

        $balance = $this->getById('user_points_balance')->getText();
        $count = floor($balance / self::TASK_PRICE);
        if ($count < 1) {
            return $this;
        }

        $this->fillText(
            '#Task_count',
            $count
        );

        $this->fillText(
            '#Task_service_url',
            self::VK_GROUP
        );

        $this->fillText(
            '#Task_price',
            self::TASK_PRICE
        );

        $this->driver->executeScript(
            '
                $(".filter-option").click(); 
                $("span:contains(\'Подписчики\')").click();
            '
        );

        $this->click('button[name="submitAdd"]');

        sleep(3);

        return $this;
    }
}
