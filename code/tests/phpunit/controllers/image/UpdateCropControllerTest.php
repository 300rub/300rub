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
        // Check DB.
        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($resultId)
            ->find();
        $this->assertSame(
            $data['viewX'],
            $imageInstanceModel->get('viewX')
        );
        $this->assertSame(
            $data['viewY'],
            $imageInstanceModel->get('viewY')
        );
        $this->assertSame(
            $data['viewWidth'],
            $imageInstanceModel->get('viewWidth')
        );
        $this->assertSame(
            $data['viewHeight'],
            $imageInstanceModel->get('viewHeight')
        );
        $this->assertSame(
            $data['thumbX'],
            $imageInstanceModel->get('thumbX')
        );
        $this->assertSame(
            $data['thumbY'],
            $imageInstanceModel->get('thumbY')
        );
        $this->assertSame(
            $data['thumbWidth'],
            $imageInstanceModel->get('thumbWidth')
        );
        $this->assertSame(
            $data['thumbHeight'],
            $imageInstanceModel->get('thumbHeight')
        );
        $this->assertSame(
            $data['viewAngle'],
            $imageInstanceModel->get('viewAngle')
        );
        $this->assertSame(
            $data['viewFlip'],
            $imageInstanceModel->get('viewFlip')
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
                    'viewX'       => 0,
                    'viewY'       => 0,
                    'viewWidth'   => 3000,
                    'viewHeight'  => 1000,
                    'thumbX'      => 0,
                    'thumbY'      => 0,
                    'thumbWidth'  => 3000,
                    'thumbHeight' => 1000,
                    'viewAngle'   => 90,
                    'viewFlip'    => 3,
                ],
                'hasError' => false
            ],
            'userPngCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.png',
                [
                    'blockId'     => 3,
                    'viewX'       => 0,
                    'viewY'       => 0,
                    'viewWidth'   => 3000,
                    'viewHeight'  => 1000,
                    'thumbX'      => 0,
                    'thumbY'      => 0,
                    'thumbWidth'  => 3000,
                    'thumbHeight' => 1000,
                    'viewAngle'   => 90,
                    'viewFlip'    => 3,
                ],
                'hasError' => false
            ],
            'blockedJpg'              => [
                'user'     => self::TYPE_BLOCKED_USER,
                'file'     => 'mediumImage.jpg',
                [
                    'blockId'     => 3,
                    'viewX'       => 0,
                    'viewY'       => 0,
                    'viewWidth'   => 3000,
                    'viewHeight'  => 1000,
                    'thumbX'      => 0,
                    'thumbY'      => 0,
                    'thumbWidth'  => 3000,
                    'thumbHeight' => 1000,
                    'viewAngle'   => 90,
                    'viewFlip'    => 3,
                ],
                'hasError' => true
            ],
        ];
    }
}
