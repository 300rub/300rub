<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateCropController
 */
class UpdateCropControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param string $file     File name
     * @param array  $data     Data
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testUpdateImage($user, $file, $data, $hasError = null)
    {
        // Create new one.
        $this->setUser(self::TYPE_FULL);
        $this->sendFile(
            'image',
            'image',
            $file,
            [
                'blockId'      => $data['blockId'],
                'imageGroupId' => 1
            ]
        );

        // Gets parameters of created.
        $body = $this->getBody();
        $resultId = $body['id'];

        // Update.
        $this->setUser($user);
        $data['id'] = $resultId;
        $this->sendRequest('image', 'crop', $data, 'PUT');

        if ($hasError === true) {
            $this->assertError();
            ImageInstanceModel::model()->byId($resultId)->find()->delete();
            return true;
        }

        $this->_checkResult($resultId, $data);

        return true;
    }

    /**
     * Checks the result
     *
     * @param integer $resultId      Result ID
     * @param array   $data          Data
     *
     * @return void
     */
    private function _checkResult($resultId, $data) {
        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($resultId)
            ->find();

        $this->assertSame(
            $data['view']['x'],
            $imageInstanceModel->get('viewX')
        );
        $this->assertSame(
            $data['view']['y'],
            $imageInstanceModel->get('viewY')
        );
        $this->assertSame(
            $data['view']['width'],
            $imageInstanceModel->get('viewWidth')
        );
        $this->assertSame(
            $data['view']['height'],
            $imageInstanceModel->get('viewHeight')
        );
        $this->assertSame(
            $data['view']['angle'],
            $imageInstanceModel->get('viewAngle')
        );
        $this->assertSame(
            $data['view']['flip'],
            $imageInstanceModel->get('viewFlip')
        );
        $this->assertSame(
            $data['thumb']['x'],
            $imageInstanceModel->get('thumbX')
        );
        $this->assertSame(
            $data['thumb']['y'],
            $imageInstanceModel->get('thumbY')
        );
        $this->assertSame(
            $data['thumb']['width'],
            $imageInstanceModel->get('thumbWidth')
        );
        $this->assertSame(
            $data['thumb']['height'],
            $imageInstanceModel->get('thumbHeight')
        );
        $this->assertSame(
            $data['thumb']['angle'],
            $imageInstanceModel->get('thumbAngle')
        );
        $this->assertSame(
            $data['thumb']['flip'],
            $imageInstanceModel->get('thumbFlip')
        );

        $imageInstanceModel->delete();
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'userJpgCorrect' => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.jpg',
                [
                    'blockId'     => 3,
                    'view' => [
                        'x'       => 0,
                        'y'       => 0,
                        'width'   => 3000,
                        'height'  => 1000,
                        'angle'   => 90,
                        'flip'    => 3,
                    ],
                    'thumb' => [
                        'x'      => 0,
                        'y'      => 0,
                        'width'  => 3000,
                        'height' => 1000,
                        'angle'  => 90,
                        'flip'   => 3,
                    ]
                ],
                'hasError' => false
            ],
            'userPngCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.png',
                [
                    'blockId'     => 3,
                    'view' => [
                        'x'       => 0,
                        'y'       => 0,
                        'width'   => 3000,
                        'height'  => 1000,
                        'angle'   => 90,
                        'flip'    => 3,
                    ],
                    'thumb' => [
                        'x'      => 0,
                        'y'      => 0,
                        'width'  => 3000,
                        'height' => 1000,
                        'angle'  => 90,
                        'flip'   => 3,
                    ]
                ],
                'hasError' => false
            ],
            'blockedJpg'              => [
                'user'     => self::TYPE_BLOCKED_USER,
                'file'     => 'mediumImage.jpg',
                [
                    'blockId'     => 3,
                    'view' => [
                        'x'       => 0,
                        'y'       => 0,
                        'width'   => 3000,
                        'height'  => 1000,
                        'angle'   => 90,
                        'flip'    => 3,
                    ],
                    'thumb' => [
                        'x'      => 0,
                        'y'      => 0,
                        'width'  => 3000,
                        'height' => 1000,
                        'angle'  => 90,
                        'flip'   => 3,
                    ]
                ],
                'hasError' => true
            ],
        ];
    }
}
