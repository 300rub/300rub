<?php

namespace ss\tests\unit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateCloneBlockDuplicationController
 */
class CreateCloneBlockDuplicationControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user          User type
     * @param int    $recordBlockId Record Block ID
     * @param int    $blockId       Block ID
     * @param bool   $hasError      Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun(
        $user,
        $recordBlockId,
        $blockId = null,
        $hasError = null
    ) {
        $this->setUser($user);

        $this->sendRequest(
            'record',
            'cloneBlockDuplication',
            [
                'recordBlockId' => $recordBlockId,
                'id'            => $blockId,
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
        $this->assertTrue($recordModel instanceof RecordCloneModel);

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
            'fullCorrect'            => [
                'user'          => self::TYPE_FULL,
                'recordBlockId' => 8,
                'blockId'       => 11,
                'hasError'      => false,
            ],
            'fullIncorrect'          => [
                'user'          => self::TYPE_FULL,
                'recordBlockId' => 8,
                'blockId'       => 9999,
                'hasError'      => true
            ],
            'fullEmpty'              => [
                'user'          => self::TYPE_FULL,
                'recordBlockId' => 8,
                'blockId'       => null,
                'hasError'      => true
            ],
            'full0'                  => [
                'user'          => self::TYPE_FULL,
                'recordBlockId' => 8,
                'blockId'       => 0,
                'hasError'      => true
            ],
            'userCorrect'            => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 8,
                'blockId'       => 11,
                'hasError'      => false,
            ],
            'userEmptyRecordBlockId' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 0,
                'blockId'       => 11,
                'hasError'      => true,
            ],
            'noOperationCorrect'     => [
                'user'          => self::TYPE_NO_OPERATIONS_USER,
                'recordBlockId' => 8,
                'blockId'       => 11,
                'hasError'      => true
            ],
        ];
    }
}
