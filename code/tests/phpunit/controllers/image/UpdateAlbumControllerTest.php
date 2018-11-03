<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\image\ImageGroupModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

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
                'seoModel' => [
                    'name' => $this->generateStringWithLength(10)
                ]
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
                    'name'        => 'New album name',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => true,
                'hasErrors' => false,
                'albumId'   => 9999
            ],
            'limitedEmpty'       => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name'        => '',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => true,
                'albumId'   => null
            ],
            'limitedLongName'    => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name'        => $this->generateStringWithLength(256),
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => true,
                'albumId'   => null
            ],
            'limitedCorrect'     => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'name'        => 'New album name',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => false,
                'albumId'   => null
            ],
            'noOperation'        => [
                'user'      => self::TYPE_NO_OPERATIONS_USER,
                'data'      => [
                    'seoModel' => [
                        'name'        => 'New album name',
                        'alias'       => '',
                        'title'       => '',
                        'keywords'    => '',
                        'description' => '',
                    ],
                ],
                'hasError'  => true,
                'hasErrors' => false,
                'albumId'   => null
            ],
        ];
    }
}
