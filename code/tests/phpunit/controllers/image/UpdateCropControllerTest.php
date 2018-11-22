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
        $this->assertSame($data['x1'], $imageInstanceModel->get('x1'));
        $this->assertSame($data['y1'], $imageInstanceModel->get('y1'));
        $this->assertSame($data['x2'], $imageInstanceModel->get('x2'));
        $this->assertSame($data['y2'], $imageInstanceModel->get('y2'));
        $this->assertSame(
            $data['thumbX1'],
            $imageInstanceModel->get('thumbX1')
        );
        $this->assertSame(
            $data['thumbY1'],
            $imageInstanceModel->get('thumbY1')
        );
        $this->assertSame(
            $data['thumbX2'],
            $imageInstanceModel->get('thumbX2')
        );
        $this->assertSame(
            $data['thumbY2'],
            $imageInstanceModel->get('thumbY2')
        );
        $this->assertSame(
            $data['angle'],
            $imageInstanceModel->get('angle')
        );
        $this->assertSame(
            $data['flip'],
            $imageInstanceModel->get('flip')
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
                    'blockId' => 3,
                    'x1'      => 0,
                    'y1'      => 0,
                    'x2'      => 3000,
                    'y2'      => 1000,
                    'thumbX1' => 0,
                    'thumbY1' => 0,
                    'thumbX2' => 3000,
                    'thumbY2' => 1000,
                    'angle'   => 90,
                    'flip'    => 3,
                ],
                'hasError' => false
            ],
            'userPngCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.png',
                [
                    'blockId' => 3,
                    'x1'      => 0,
                    'y1'      => 0,
                    'x2'      => 3000,
                    'y2'      => 1000,
                    'thumbX1' => 0,
                    'thumbY1' => 0,
                    'thumbX2' => 3000,
                    'thumbY2' => 1000,
                    'angle'   => 90,
                    'flip'    => 3,
                ],
                'hasError' => false
            ],
            'blockedJpg'              => [
                'user'     => self::TYPE_BLOCKED_USER,
                'file'     => 'mediumImage.jpg',
                [
                    'blockId' => 3,
                    'x1'      => 0,
                    'y1'      => 0,
                    'x2'      => 3000,
                    'y2'      => 1000,
                    'thumbX1' => 0,
                    'thumbY1' => 0,
                    'thumbX2' => 3000,
                    'thumbY2' => 1000,
                    'angle'   => 90,
                    'flip'    => 3,
                ],
                'hasError' => true
            ],
        ];
    }
}
