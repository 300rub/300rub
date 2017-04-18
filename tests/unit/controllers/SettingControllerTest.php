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
                self::TYPE_NO_OPERATIONS_USER,
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

    /**
     * Test for getSeo
     *
     * @param string $user
     * @param array  $expected
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestGetSeo
     */
    public function testGetSeo($user, $expected, $hasError = false)
    {
        $this->setUser($user);
        $this->sendRequest("settings", "seo");

        if ($hasError === false) {
            $this->compareExpectedAndActual($expected, $this->getBody(), true);
        } else {
            $this->assertError();
        }
    }

    /**
     * Data provider for testGetSeo
     *
     * @return array
     */
    public function dataProviderForTestGetSeo()
    {
        return [
            [
                null,
                [],
                true
            ],
            [
                self::TYPE_NO_OPERATIONS_USER,
                [],
                true
            ],
            [
                self::TYPE_BLOCKED_USER,
                [],
                true
            ],
            [
                self::TYPE_USER,
                [
                    "title"       => "Title",
                    "keywords"    => "Keywords",
                    "description" => "Description",
                ]
            ],
            [
                self::TYPE_ADMIN,
                [
                    "title"       => "Title",
                    "keywords"    => "Keywords",
                    "description" => "Description",
                ]
            ]
        ];
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