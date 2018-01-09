<?php

namespace testS\tests\unit\controllers\image;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteAlbumController
 */
class DeleteAlbumControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param bool   $hasError Error flag
     * @param int    $albumId  Album ID
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $hasError = null, $albumId = null)
    {
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

        $this->sendRequest(
            'image',
            'album',
            [
                'blockId' => 3,
                'id'      => $albumId
            ],
            'DELETE'
        );

        if ($hasError === true) {
            $this->assertError();
            $this->assertNotNull(
                $imageGroupModel->byId($imageGroupModel->getId())->find()
            );
            $imageGroupModel->delete();
            return true;
        }

        $expected = [
            'result' => true
        ];
        $this->assertSame($expected, $this->getBody());
        $this->assertNull(
            $imageGroupModel->byId($imageGroupModel->getId())->find()
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
            'limitedIncorrectId' => [
                'user'     => self::TYPE_LIMITED,
                'hasError' => true,
                'albumId'  => 9999
            ],
            'limited'            => [
                'user'     => self::TYPE_LIMITED,
                'hasError' => false,
                'albumId'  => null
            ],
            'noOperation'        => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'hasError' => true,
                'albumId'  => null
            ],
        ];
    }
}
