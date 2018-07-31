<?php

namespace ss\tests\phpunit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteCloneBlockController
 */
class DeleteCloneBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user          User type
     * @param int    $recordBlockId Record Block ID
     * @param int    $recordId      Record ID
     * @param int    $blockId       Block ID
     * @param bool   $hasError      Error flag
     *
     * @dataProvider dataProvider
     *
     * @return true
     */
    public function testRun(
        $user,
        $recordBlockId,
        $recordId,
        $blockId = null,
        $hasError = null
    ) {
        $this->setUser($user);

        $blockModel = null;
        $requestId = $blockId;

        if ($blockId === null) {
            $recordCloneModel = new RecordCloneModel();
            $recordCloneModel->set(['recordId' => $recordId]);
            $recordCloneModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    'name'        => 'name',
                    'language'    => 1,
                    'contentType' => BlockModel::TYPE_RECORD_CLONE,
                    'contentId'   => $recordCloneModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        }

        $this->sendRequest(
            'record',
            'cloneBlock',
            [
                'recordBlockId' => $recordBlockId,
                'id'            => $requestId,
            ],
            'DELETE'
        );

        if ($hasError === true) {
            $this->assertError();

            if ($blockId === null) {
                $blockModel->delete();
            }

            return true;
        }

        $expected = [
            'result' => true
        ];

        $this->compareExpectedAndActual($expected, $this->getBody());

        $this->assertNull(
            BlockModel::model()->byId($blockModel->getId())->find()
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
            'userCorrect'            => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'recordId'      => 1,
                'blockId'       => null,
                'hasError'      => false
            ],
            'userEmptyRecordBlockId' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 0,
                'recordId'      => 1,
                'blockId'       => null,
                'hasError'      => true
            ],
            'userIncorrect'          => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'recordId'      => 1,
                'blockId'       => 9999,
                'hasError'      => true
            ],
            'blocked'                => [
                'user'          => self::TYPE_BLOCKED_USER,
                'recordBlockId' => 6,
                'recordId'      => 1,
                'blockId'       => null,
                'hasError'      => true
            ],
            'noOperation'            => [
                'user'          => self::TYPE_NO_OPERATIONS_USER,
                'recordBlockId' => 6,
                'recordId'      => 1,
                'blockId'       => null,
                'hasError'      => true
            ],
        ];
    }
}
