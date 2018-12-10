<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteImageController
 */
class DeleteImageControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user       User type
     * @param bool   $hasError   Error flag
     * @param int    $instanceId Instance ID
     *
     * @dataProvider dataProvider
     *
     * @return true
     */
    public function testRun($user, $hasError = null, $instanceId = null)
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
                    'uniqueName' => uniqid() .'.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => uniqid() .'.jpg',
                ],
            ]
        );
        $imageInstanceModel->save();

        if ($instanceId === null) {
            $instanceId = $imageInstanceModel->getId();
        }

        $this->sendRequest(
            'image',
            'image',
            [
                'blockId' => 3,
                'id'      => $instanceId
            ],
            'DELETE'
        );

        if ($hasError === true) {
            $this->assertError();
            $this->assertNotNull(
                $imageInstanceModel
                    ->byId($imageInstanceModel->getId())
                    ->find()
            );
            $imageInstanceModel->delete();
            return true;
        }

        $expected = [
            'result' => true
        ];
        $this->assertSame($expected, $this->getBody());
        $this->assertNull(
            $imageInstanceModel
                ->byId($imageInstanceModel->getId())
                ->find()
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
            'limitedIncorrectId'     => [
                'user'       => self::TYPE_LIMITED,
                'hasError'   => true,
                'instanceId' => 9999
            ],
            'limitedIncorrectFormat' => [
                'user'       => self::TYPE_LIMITED,
                'hasError'   => true,
                'instanceId' => '1'
            ],
            'limitedCorrect'         => [
                'user'       => self::TYPE_LIMITED,
                'hasError'   => false,
                'instanceId' => null
            ],
            'noOperation'            => [
                'user'       => self::TYPE_NO_OPERATIONS_USER,
                'hasError'   => true,
                'instanceId' => null
            ],
        ];
    }
}
