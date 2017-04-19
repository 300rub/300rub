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
                [
                    "result" => [
                        "users" => [
                            "name"       => "Users",
                            "controller" => "user",
                            "action"     => "users",
                        ],
                    ]
                ]
            ],
            [
                self::TYPE_FULL,
                [
                    "result" => [
                        "users" => [
                            "name"       => "Users",
                            "controller" => "user",
                            "action"     => "users",
                        ],
                        "icon"  => [
                            "name"       => "Icon",
                            "controller" => "settings",
                            "action"     => "icon",
                        ],
                    ]
                ]
            ],
        ];
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