<?php

namespace ss\tests\unit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteBlockController
 */
class DeleteBlockControllerTest extends AbstractControllerTest
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
     * @return true
     */
    public function testRun($user, $blockId = null, $hasError = null)
    {
        $this->setUser($user);

        $blockModel = null;
        $requestId = $blockId;

        if ($blockId === null) {
            $recordModel = new RecordModel();
            $recordModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    'name'        => 'name',
                    'language'    => 1,
                    'contentType' => BlockModel::TYPE_RECORD,
                    'contentId'   => $recordModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        }

        $this->sendRequest('record', 'block', ['id' => $requestId], 'DELETE');

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
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'hasError' => false
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => null,
                'hasError' => true
            ],
            'blockedIncorrect'     => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => null,
                'hasError' => true
            ],
            'noOperationIncorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 9999,
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'blockId'  => null,
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
