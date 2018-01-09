<?php

namespace testS\tests\unit\controllers\image;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateContentController
 */
class UpdateContentControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param array  $data     Data
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($user, $data, $hasError)
    {
        $this->setUser($user);

        $this->sendRequest('image', 'content', $data, 'PUT');

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->assertSame(
            [
                'result' => true
            ],
            $this->getBody()
        );

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
            'userUpdateAlbums' => [
                'user'     => self::TYPE_LIMITED,
                'data'     => [
                    'id'      => 4,
                    'groupId' => 0,
                    'list'    => [2, 3],
                ],
                'hasError' => false,
            ],
            'userUpdateImages' => [
                'user'     => self::TYPE_LIMITED,
                'data'     => [
                    'id'      => 3,
                    'groupId' => 0,
                    'list'    => [1, 2],
                ],
                'hasError' => false,
            ],
            'userUpdateAlbum' => [
                'user'     => self::TYPE_LIMITED,
                'data'     => [
                    'id'      => 3,
                    'groupId' => 1,
                    'list'    => [1, 2],
                ],
                'hasError' => false,
            ],
            'userUpdateAlbumIncorrect' => [
                'user'     => self::TYPE_LIMITED,
                'data'     => [
                    'id'      => 3,
                    'groupId' => 1,
                    'list'    => [1, 2, 9999],
                ],
                'hasError' => true,
            ],
            'userWithNoOperations' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'data'     => [
                    'id'      => 4,
                    'groupId' => 0,
                    'list'    => [2, 3],
                ],
                'hasError' => true,
            ],
        ];
    }
}
