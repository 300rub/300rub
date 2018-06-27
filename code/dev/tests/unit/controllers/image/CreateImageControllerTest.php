<?php

namespace ss\tests\unit\controllers\image;

use ss\application\App;
use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateImageController
 */
class CreateImageControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param string $file     File name
     * @param int    $blockId  Block ID
     * @param int    $albumId  Album ID
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testCreateImage(
        $user,
        $file,
        $blockId,
        $albumId,
        $hasError = null
    ) {
        $this->setUser($user);
        $this->sendFile(
            'image',
            'image',
            $file,
            [
                'blockId'      => $blockId,
                'imageGroupId' => $albumId
            ]
        );

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $body = $this->getBody();

        $originalFileExplode = explode('/', $body['originalUrl']);
        $originalFile = $originalFileExplode[(count($originalFileExplode) - 1)];
        $originalFilePath = sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->get('name'),
            $originalFile
        );
        $this->assertTrue(file_exists($originalFilePath));

        $viewFileExplode = explode('/', $body['viewUrl']);
        $viewFile = $viewFileExplode[(count($viewFileExplode) - 1)];
        $viewFilePath = sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->get('name'),
            $viewFile
        );
        $this->assertTrue(file_exists($viewFilePath));

        $thumbFileExplode = explode('/', $body['thumbUrl']);
        $thumbFile = $thumbFileExplode[(count($thumbFileExplode) - 1)];
        $thumbFilePath = sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->get('name'),
            $thumbFile
        );
        $this->assertTrue(file_exists($thumbFilePath));

        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($body['id'])
            ->find();
        $this->assertNotNull($imageInstanceModel);

        $this->assertSame(
            $originalFile,
            $imageInstanceModel->get('originalFileModel')->get('uniqueName')
        );
        $this->assertSame(
            $viewFile,
            $imageInstanceModel->get('viewFileModel')->get('uniqueName')
        );
        $this->assertSame(
            $thumbFile,
            $imageInstanceModel->get('thumbFileModel')->get('uniqueName')
        );

        $imageInstanceModel->delete();

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
            'userJpgCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.jpg',
                'blockId'  => 3,
                'albumId'  => 1,
                'hasError' => false
            ],
            'userPngCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.png',
                'blockId'  => 3,
                'albumId'  => 1,
                'hasError' => false
            ],
            'userJpgIncorrectAlbumId' => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.jpg',
                'blockId'  => 3,
                'albumId'  => 999,
                'hasError' => true
            ],
            'userJpgEmptyAlbumId'     => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'mediumImage.jpg',
                'blockId'  => 3,
                'albumId'  => 0,
                'hasError' => true
            ],
            'userIncorrectFormat'     => [
                'user'     => self::TYPE_LIMITED,
                'file'     => 'file.txt',
                'blockId'  => 3,
                'albumId'  => 1,
                'hasError' => true
            ],
            'blockedJpg'              => [
                'user'     => self::TYPE_BLOCKED_USER,
                'file'     => 'mediumImage.jpg',
                'blockId'  => 3,
                'albumId'  => 1,
                'hasError' => true
            ],
        ];
    }
}
