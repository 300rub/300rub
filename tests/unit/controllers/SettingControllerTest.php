<?php

namespace testS\tests\unit\controllers;

/**
 * Tests for the controller SettingController
 *
 * @package testS\tests\unit\controllers
 */
class SettingControllerTest extends AbstractControllerTest
{

    /**
     * Test for getSettings
     *
     * @param string $user
     * @param array  $expected
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestGetSettings
     */
    public function testGetSettings($user, $expected, $hasError = false)
    {
        $this->setUser($user);
        $this->sendRequest("settings", "settings");

        if ($hasError === false) {
            $this->compareExpectedAndActual($expected, $this->getBody(), true);
        } else {
            $this->assertError();
        }
    }

    /**
     * Data provider for testGetSettings
     *
     * @return array
     */
    public function dataProviderForTestGetSettings()
    {
        return [
            [
                null,
                [],
                true
            ],
            [
                self::TYPE_USER,
                [
                    "result" => [
                        "seo" => [
                            "name"       => "SEO",
                            "controller" => "settings",
                            "action"     => "seo",
                        ],
                    ]
                ]
            ],
            [
                self::TYPE_ADMIN,
                [
                    "result" => [
                        "seo"   => [
                            "name"       => "SEO",
                            "controller" => "settings",
                            "action"     => "seo",
                        ],
                        "icon"  => [
                            "name"       => "Icon",
                            "controller" => "settings",
                            "action"     => "icon",
                        ],
                        "users" => [
                            "name"       => "Users",
                            "controller" => "user",
                            "action"     => "users",
                        ],
                    ]
                ]
            ],
        ];
    }

    public function testGetSeo()
    {
        $this->markTestSkipped();
    }

    public function testUpdateSeo()
    {
        $this->markTestSkipped();
    }

    public function testGetIcon()
    {
        $this->markTestSkipped();
    }

    public function testUpdateIcon()
    {
        $this->markTestSkipped();
    }
}