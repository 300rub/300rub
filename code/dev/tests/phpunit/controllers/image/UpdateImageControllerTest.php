<?php

namespace ss\tests\unit\controllers\image;

use ss\application\App;
use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateImageController
 */
class UpdateImageControllerTest extends AbstractControllerTest
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
        $config = App::getInstance()->getConfig();

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
        $originalFileName = explode('/', $body['originalUrl']);
        $originalFileName = end($originalFileName);
        $viewFileName = explode('/', $body['viewUrl']);
        $viewFileName = end($viewFileName);
        $thumbFileName = explode('/', $body['thumbUrl']);
        $thumbFileName = end($thumbFileName);

        // Make sure that files exist.
        $this->assertFileExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $originalFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $viewFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $thumbFileName
            )
        );

        // Update.
        $this->setUser($user);
        $data['id'] = $resultId;
        $this->sendRequest('image', 'image', $data, 'PUT');

        if ($hasError === true) {
            $this->assertError();
            ImageInstanceModel::model()->byId($resultId)->find()->delete();
            return true;
        }

        $this->_checkResult(
            $originalFileName,
            $viewFileName,
            $thumbFileName,
            $resultId,
            $data
        );

        return true;
    }

    /**
     * Checks the result
     *
     * @param string  $originalFileName Original file name
     * @param string  $viewFileName     View file name
     * @param string  $thumbFileName    Thumb file name
     * @param integer $resultId         Result ID
     * @param array   $data             Data
     *
     * @return void
     */
    private function _checkResult(
        $originalFileName,
        $viewFileName,
        $thumbFileName,
        $resultId,
        $data
    ) {
        $config = App::getInstance()->getConfig();

        // Compare.
        $body = $this->getBody();
        $newOriginalFileName = explode('/', $body['originalUrl']);
        $newOriginalFileName = end($newOriginalFileName);
        $updatedViewFileName = explode('/', $body['viewUrl']);
        $updatedViewFileName = end($updatedViewFileName);
        $updatedThumbFileName = explode('/', $body['thumbUrl']);
        $updatedThumbFileName = end($updatedThumbFileName);
        $this->assertSame($originalFileName, $newOriginalFileName);
        $this->assertNotSame($viewFileName, $updatedViewFileName);
        $this->assertNotSame($thumbFileName, $updatedThumbFileName);

        // Make sure new files exist.
        $this->assertFileExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $updatedViewFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $updatedThumbFileName
            )
        );

        // Make sure old files don't exist.
        $this->assertFileNotExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $viewFileName
            )
        );
        $this->assertFileNotExists(
            sprintf(
                $config->getValue(['file', 'pathMask']),
                App::getInstance()->getSite()->get('name'),
                $thumbFileName
            )
        );

        // Check DB.
        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($resultId)
            ->find();
        $this->assertSame(
            $data['isCover'],
            $imageInstanceModel->get('isCover')
        );
        $this->assertSame($data['alt'], $imageInstanceModel->get('alt'));
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
                    'isCover' => true,
                    'alt'     => 'New alt',
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
                    'isCover' => true,
                    'alt'     => 'New alt',
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
                    'isCover' => true,
                    'alt'     => 'New alt',
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
