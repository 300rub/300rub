<?php

namespace testS\tests\unit\controllers\block;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetSettingsController
 */
class GetSettingsControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param array  $expected Expected data
     * @param bool   $hasError Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $expected, $hasError = null)
    {
        $this->setUser($user);
        $this->sendRequest('settings', 'settings');

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody(), true);
        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
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
                    'title'       => 'Settings',
                    'description' => 'description...',
                    'list'        => [
                        'users' => 'Users',
                    ]
                ]
            ],
            [
                self::TYPE_FULL,
                [
                    'title'       => 'Settings',
                    'description' => 'description...',
                    'list'        => [
                        'users' => 'Users',
                        'icon'  => 'Icon',
                    ]
                ]
            ],
        ];
    }
}
