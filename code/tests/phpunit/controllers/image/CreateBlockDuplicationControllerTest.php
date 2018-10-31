<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateBlockDuplicationController
 */
class CreateBlockDuplicationControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param bool   $hasError Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $blockId = null, $hasError = null)
    {
        $this->setUser($user);

        $this->sendRequest(
            'image',
            'blockDuplication',
            [
                'id' => $blockId
            ],
            'POST'
        );

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $body = $this->getBody();
        $this->assertTrue($body['id'] > $blockId);

        $blockModel = BlockModel::model()->getLatest();

        $imageModel = $blockModel->getContentModel();
        $this->assertTrue($imageModel instanceof ImageModel);

        $blockModel->delete();

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
            'fullCorrect'          => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 3,
                'hasError' => false,
            ],
            'fullIncorrect'        => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 3,
                'hasError' => false,
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 3,
                'hasError' => true
            ],
            'blockedIncorrect'     => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 3,
                'hasError' => true
            ],
            'noOperationIncorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'blockId'  => 3,
                'hasError' => true
            ],
            'guestIncorrect'       => [
                'user'     => null,
                'blockId'  => 9999,
                'hasError' => true
            ],
        ];
    }
}
