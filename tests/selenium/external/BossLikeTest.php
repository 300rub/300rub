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
    const TASK_PRICE = 25;

    /**
     * Loop count
     */
    const LOOP_COUNT = 5;

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
                'vkPass' => 'vk2pasS77',
                'blUser' => 'vk447894241250@yandex.ru',
                'blPass' => 'pass447894241250',
                'cookie' => [
                    [
                        'name'    => '1711acb810d1e29fc748352d59f5bda8',
                        'content' => 'f32cb5dde377b837ea27c912fab2bf97db894707s%3A253%3A%22d0a77660534189a1c1b1b0641f7d3245c4e0e127a%3A4%3A%7Bi%3A0%3Bs%3A7%3A%222225837%22%3Bi%3A1%3Bs%3A14%3A%22vk447894241250%22%3Bi%3A2%3Bi%3A31536000%3Bi%3A3%3Ba%3A4%3A%7Bs%3A2%3A%22id%22%3Bs%3A7%3A%222225837%22%3Bs%3A4%3A%22name%22%3Bs%3A14%3A%22vk447894241250%22%3Bs%3A10%3A%22login_time%22%3Bi%3A1520023165%3Bs%3A4%3A%22auth%22%3Bs%3A32%3A%220c34823fcc80aba36b6a49629e0ad9c8%22%3B%7D%7D%22%3B',
                    ]
                ]
            ],
            '447902599250' => [
                'vkUser' => '447902599250',
                'vkPass' => 'vk1pasS77',
                'blUser' => 'vk447902599250@yandex.ru',
                'blPass' => 'pass447902599250',
                'cookie' => [
                    [
                        'name'    => '1711acb810d1e29fc748352d59f5bda8',
                        'content' => '0f42eed5ed13579b1808dd6604fd73c2eced28a3s%3A253%3A%22220e66dcc8cecc7a0ca5a6a89b65254dcef31f00a%3A4%3A%7Bi%3A0%3Bs%3A7%3A%222245948%22%3Bi%3A1%3Bs%3A14%3A%22vk447902599250%22%3Bi%3A2%3Bi%3A31536000%3Bi%3A3%3Ba%3A4%3A%7Bs%3A2%3A%22id%22%3Bs%3A7%3A%222245948%22%3Bs%3A4%3A%22name%22%3Bs%3A14%3A%22vk447902599250%22%3Bs%3A10%3A%22login_time%22%3Bi%3A1520025166%3Bs%3A4%3A%22auth%22%3Bs%3A32%3A%22ecd4c2a6d0cd0d179d6be309576db492%22%3B%7D%7D%22%3B',
                    ]
                ]
            ],
            '447468771254' => [
                'vkUser' => '447468771254',
                'vkPass' => 'vk1pasS77',
                'blUser' => 'vk447468771254@yandex.ru',
                'blPass' => 'pass447468771254',
                'cookie' => [
                    [
                        'name'    => '1711acb810d1e29fc748352d59f5bda8',
                        'content' => 'a2d0d1a5965b2243404f249b0e54e9c33f943422s%3A253%3A%222634bc16938c2fc3843ccb3c1ce81e7de03722b4a%3A4%3A%7Bi%3A0%3Bs%3A7%3A%222246272%22%3Bi%3A1%3Bs%3A14%3A%22vk447468771254%22%3Bi%3A2%3Bi%3A31536000%3Bi%3A3%3Ba%3A4%3A%7Bs%3A2%3A%22id%22%3Bs%3A7%3A%222246272%22%3Bs%3A4%3A%22name%22%3Bs%3A14%3A%22vk447468771254%22%3Bs%3A10%3A%22login_time%22%3Bi%3A1520027883%3Bs%3A4%3A%22auth%22%3Bs%3A32%3A%2229d1bed6dda017be1fa2017e2868507e%22%3B%7D%7D%22%3B',
                    ]
                ]
            ],
            '447468771543' => [
                'vkUser' => '447468771543',
                'vkPass' => 'vk1pasS77',
                'blUser' => 'vk447468771543@yandex.ru',
                'blPass' => 'pass447468771543',
                'cookie' => [
                    [
                        'name'    => '1711acb810d1e29fc748352d59f5bda8',
                        'content' => 'ab1a41c7e86d9cab599573719639bf8198b0db73s%3A253%3A%229cd53796494483209482ea06956f469f1fc02342a%3A4%3A%7Bi%3A0%3Bs%3A7%3A%222246904%22%3Bi%3A1%3Bs%3A14%3A%22vk447468771543%22%3Bi%3A2%3Bi%3A31536000%3Bi%3A3%3Ba%3A4%3A%7Bs%3A2%3A%22id%22%3Bs%3A7%3A%222246904%22%3Bs%3A4%3A%22name%22%3Bs%3A14%3A%22vk447468771543%22%3Bs%3A10%3A%22login_time%22%3Bi%3A1520065377%3Bs%3A4%3A%22auth%22%3Bs%3A32%3A%22c111a0d65fb600719a0bca7cdacb1d89%22%3B%7D%7D%22%3B',
                    ]
                ]
            ],
            '447543186265' => [
                'vkUser' => '447543186265',
                'vkPass' => 'vk1pasS77',
                'blUser' => 'vk447543186265@yandex.ru',
                'blPass' => 'pass447543186265',
                'cookie' => [
                    [
                        'name'    => '1711acb810d1e29fc748352d59f5bda8',
                        'content' => '837ac6885fbe892e2c968f461d27900b9ec07c70s%3A253%3A%22f077c9a5b54ca190b7cdb28b2e0067ab80fb2bbda%3A4%3A%7Bi%3A0%3Bs%3A7%3A%222246970%22%3Bi%3A1%3Bs%3A14%3A%22vk447543186265%22%3Bi%3A2%3Bi%3A31536000%3Bi%3A3%3Ba%3A4%3A%7Bs%3A2%3A%22id%22%3Bs%3A7%3A%222246970%22%3Bs%3A4%3A%22name%22%3Bs%3A14%3A%22vk447543186265%22%3Bs%3A10%3A%22login_time%22%3Bi%3A1520067024%3Bs%3A4%3A%22auth%22%3Bs%3A32%3A%221a29b424e1943c0c4598d8dc1d168083%22%3B%7D%7D%22%3B',
                    ]
                ]
            ],
        ];
    }

    /**
     * Like test
     *
     * @param string $vkUser  VK user
     * @param string $vkPass  VK pass
     * @param string $blUser  BossLike user
     * @param string $blPass  BossLike pass
     * @param array  $cookies Cookie
     *
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testLike(
        $vkUser,
        $vkPass,
        $blUser,
        $blPass,
        $cookies
    ) {
        $this
            ->_vkLogin($vkUser, $vkPass)
            ->_bossLikeLogin($blUser, $blPass)
            ->_bossLikeLoginByCookie($cookies)
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

    private function _bossLikeLoginByCookie($cookies)
    {
        $this->driver->get('http://bosslike.ru/');

        foreach ($cookies as $cookie) {
            $this->driver->manage()->addCookie(
                [
                    'name'   => $cookie['name'],
                    'value'  => $cookie['content'],
                ]
            );
        }

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
        if (1 === 1) {
            return $this;
        }

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

        $this->driver->executeScript(
            '
                $("#task-menu .sidebar-header .btn-block").click(); 
            '
        );

        sleep(1);

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
