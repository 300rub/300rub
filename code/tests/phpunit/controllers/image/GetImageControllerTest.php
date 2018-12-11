<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

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
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'viewFileModel'     => [
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'alt'               => 'Alt 1',
                'width'             => 800,
                'height'            => 600,
                'viewX'             => 10,
                'viewY'             => 30,
                'viewWidth'         => 70,
                'viewHeight'        => 80,
                'thumbX'            => 5,
                'thumbY'            => 15,
                'thumbWidth'        => 35,
                'thumbHeight'       => 45,
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
            'forms' => [
                'isCover' => [
                    'value' => false
                ],
                'alt'     => [
                    'value' => 'Alt 1'
                ],
                'link'    => [
                    'value' => ''
                ],
            ]
        ];

        $this->compareExpectedAndActual($expected, $body);

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
