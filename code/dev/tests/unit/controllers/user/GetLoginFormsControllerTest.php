<?php

namespace ss\tests\unit\controllers\user;

use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetLoginFormsController
 */
class GetLoginFormsControllerTest extends AbstractControllerTest
{

    /**
     * Test for getting login forms
     *
     * @param string $userType     User type
     * @param array  $expectedData Expected data
     * @param bool   $isError      Flag of error
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($userType, $expectedData, $isError)
    {
        $this->setUser($userType);

        $this->sendRequest('user', 'loginForms');

        $actualBody = $this->getBody();

        if ($isError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expectedData, $actualBody, true);

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
                self::TYPE_OWNER,
                [],
                true
            ],
            [
                self::TYPE_LIMITED,
                [],
                true
            ],
            [
                null,
                [
                    'title' => 'Login',
                    'forms' => [
                        'user'       => [
                            'name'       => 'user',
                            'label'      => 'User',
                            'validation' => [
                                'required'
                                    => 'required',
                                'minLength'
                                    => 3,
                                'maxLength'
                                    => 50,
                                'latinDigitUnderscoreHyphen'
                                    => 'latinDigitUnderscoreHyphen'
                            ]
                        ],
                        'password'   => [
                            'name'       => 'password',
                            'label'      => 'Password',
                            'validation' => [
                                'required'  => 'required',
                                'minLength' => 3,
                                'maxLength' => 40,
                            ]
                        ],
                        'isRemember' => [
                            'name'  => 'isRemember',
                            'label' => 'Remember me',
                        ],
                        'button'     => [
                            'label'      => 'Go',
                        ]
                    ]
                ],
                false
            ],
        ];
    }
}
