<?php

namespace ss\tests\phpunit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;
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
            'record',
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

        $recordModel = $blockModel->getContentModel();
        $this->assertTrue($recordModel instanceof RecordModel);

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
                'blockId'  => 6,
                'hasError' => false,
            ],
            'fullIncorrect'        => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'fullEmpty'    => [
                'user'     => self::TYPE_FULL,
                'blockId'  => null,
                'hasError' => true
            ],
            'full0'        => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 0,
                'hasError' => true
            ],
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 6,
                'hasError' => false,
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 6,
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 6,
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'blockId'  => 6,
                'hasError' => true
            ],
        ];
    }
}
