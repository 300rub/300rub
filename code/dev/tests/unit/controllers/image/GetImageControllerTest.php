<?php

namespace ss\tests\unit\controllers\image;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetImageController
 */
class GetImageControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param bool   $hasError Error flag
     * @param int    $imageId  Image instance ID
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $hasError = null, $imageId = null)
    {
        $this->setUser($user);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => 'new_file.jpg',
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_new_file.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_new_file.jpg',
                ],
                'alt'               => 'Alt 1',
                'width'             => 800,
                'height'            => 600,
                'x1'                => 10,
                'y1'                => 30,
                'x2'                => 70,
                'y2'                => 80,
                'thumbX1'           => 5,
                'thumbY1'           => 15,
                'thumbX2'           => 35,
                'thumbY2'           => 45,
            ]
        );
        $imageInstanceModel->save();

        if ($imageId === null) {
            $imageId = $imageInstanceModel->getId();
        }

        $this->sendRequest(
            'image',
            'image',
            [
                'blockId' => 3,
                'id'      => $imageId
            ]
        );

        if ($hasError === true) {
            $this->assertError();
            $imageInstanceModel->delete();
            return true;
        }

        $body = $this->getBody();
        $expected = [
            'alt'     => 'Alt 1',
            'width'   => 800,
            'height'  => 600,
            'x1'      => 10,
            'y1'      => 30,
            'x2'      => 70,
            'y2'      => 80,
            'thumbX1' => 5,
            'thumbY1' => 15,
            'thumbX2' => 35,
            'thumbY2' => 45,
        ];
        $this->compareExpectedAndActual($expected, $body);
        $this->assertTrue(strpos($body['url'], 'new_file.jpg') > 0);

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
            'limitedIncorrectId'     => [
                'user'     => self::TYPE_LIMITED,
                'hasError' => true,
                'imageId'  => 9999
            ],
            'limited'              => [
                'user'     => self::TYPE_LIMITED,
                'hasError' => false,
                'imageId'  => null
            ],
            'guest'                => [
                'user'     => null,
                'hasError' => true,
                'imageId'  => null
            ],
            'blocked'              => [
                'user'     => self::TYPE_BLOCKED_USER,
                'hasError' => true,
                'imageId'  => null
            ],
        ];
    }
}
