<?php

namespace testS\tests\unit\controllers\image;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateAlbumController
 */
class UpdateAlbumControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user      User type
     * @param array  $data      Data
     * @param bool   $hasError  Error flag
     * @param bool   $hasErrors Errors flag
     * @param int    $albumId   Album ID
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testUpdateAlbum(
        $user,
        $data,
        $hasError = null,
        $hasErrors = null,
        $albumId = null
    ) {
        $this->setUser($user);

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                'imageId' => 1,
                'name'    => $this->generateStringWithLength(10)
            ]
        );
        $imageGroupModel->save();

        if ($albumId === null) {
            $albumId = $imageGroupModel->getId();
        }

        $data = array_merge(
            $data,
            [
                'blockId' => 3,
                'id'      => $albumId
            ]
        );

        $this->sendRequest('image', 'album', $data, 'PUT');

        if ($hasError === true) {
            $this->assertError();
            $imageGroupModel->delete();
            return true;
        }

        if ($hasErrors === true) {
            $this->assertErrors();
            $imageGroupModel->delete();
            return true;
        }

        $expected = [
            'result' => true
        ];
        $this->assertSame($expected, $this->getBody());

        $imageGroupModel->delete();
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
            'limitedIncorrectId' => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name' => 'New album name',
                ],
                'hasError'  => true,
                'hasErrors' => false,
                'albumId'   => 9999
            ],
            'limitedEmpty'       => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name' => '',
                ],
                'hasError'  => false,
                'hasErrors' => true,
                'albumId'   => null
            ],
            'limitedLongName'    => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name' => $this->generateStringWithLength(256),
                ],
                'hasError'  => false,
                'hasErrors' => true,
                'albumId'   => null
            ],
            'limitedCorrect'     => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name' => 'New album name',
                ],
                'hasError'  => false,
                'hasErrors' => false,
                'albumId'   => null
            ],
            'noOperation'        => [
                'user'      => self::TYPE_NO_OPERATIONS_USER,
                'data'      => [
                    'name' => 'New album name',
                ],
                'hasError'  => true,
                'hasErrors' => false,
                'albumId'   => null
            ],
        ];
    }
}