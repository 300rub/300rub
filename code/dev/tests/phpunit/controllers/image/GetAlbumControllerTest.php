<?php

namespace ss\tests\phpunit\controllers\image;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetAlbumController
 */
class GetAlbumControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user        User type
     * @param int    $blockId     Block ID
     * @param int    $albumId     Album ID
     * @param bool   $hasError    Error flag
     * @param bool   $hasErrors   Errors flag
     * @param string $title       Title
     * @param string $name        Name
     * @param string $buttonLabel Button label
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun(
        $user,
        $blockId,
        $albumId,
        $hasError,
        $hasErrors = null,
        $title = null,
        $name = null,
        $buttonLabel = null
    ) {
        $this->setUser($user);

        $this->sendRequest(
            'image',
            'album',
            [
                'blockId' => $blockId,
                'id'      => $albumId
            ]
        );

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        if ($hasErrors === true) {
            $this->assertErrors();
            return true;
        }

        $expected = [
            'blockId' => $blockId,
            'title'   => $title,
            'forms'   => [
                'name'   => [
                    'name'       => 'name',
                    'label'      => 'Name',
                    'validation' => [
                        'required'  => 'required',
                        'maxLength' => 255
                    ],
                    'value'      => $name,
                ],
                'button' => [
                    'label' => $buttonLabel,
                ]
            ]
        ];

        $this->compareExpectedAndActual($expected, $this->getBody());

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
            'userUpdateCorrect'          => [
                'user'      => self::TYPE_LIMITED,
                'blockId'   => 3,
                'albumId'   => 1,
                'hasError'  => false,
                'hasErrors' => false,
                'title'     => 'Update album',
                'name'      => 'Name',
                $buttonLabel = 'Update'
            ],
            'userCreateCorrect'          => [
                'user'      => self::TYPE_LIMITED,
                'blockId'   => 3,
                'albumId'   => 0,
                'hasError'  => false,
                'hasErrors' => false,
                'title'     => 'Create album',
                'name'      => '',
                $buttonLabel = 'Add'
            ],
            'userUpdateIncorrectId'      => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 3,
                'albumId'  => 999,
                'hasError' => true,
            ],
            'userUpdateIncorrectBlockId' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 999,
                'albumId'  => 1,
                'hasError' => true,
            ],
            'noOperationUpdate'          => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 3,
                'albumId'  => 1,
                'hasError' => true,
            ],
            'noOperationCreate'          => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 3,
                'albumId'  => 0,
                'hasError' => true,
            ],
        ];
    }
}
