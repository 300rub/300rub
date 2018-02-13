<?php

namespace ss\tests\unit\controllers\text;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;
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
     * @return bool
     */
    public function testRun($user, $blockId = null, $hasError = null)
    {
        $this->setUser($user);

        $blockModel = null;
        $requestId = $blockId;
        if ($blockId === null) {
            $textModel = new TextModel();
            $textModel->set(
                [
                    'type'      => 0,
                    'hasEditor' => 0,
                ]
            );
            $textModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    'name'        => 'name',
                    'language'    => 1,
                    'contentType' => BlockModel::TYPE_TEXT,
                    'contentId'   => $textModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        }

        $this->sendRequest('text', 'block', ['id' => $requestId], 'DELETE');

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
            'fullCorrect'          => [
                'user'     => self::TYPE_FULL,
                'id'       => null,
                'hasError' => false
            ],
            'fullIncorrect'        => [
                'user'     => self::TYPE_FULL,
                'id'       => 9999,
                'hasError' => true
            ],
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'id'       => null,
                'hasError' => false
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 9999,
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => null,
                'hasError' => true
            ],
            'blockedIncorrect'     => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 9999,
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => null,
                'hasError' => true
            ],
            'noOperationIncorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 9999,
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'id'       => null,
                'hasError' => true
            ],
            'guestIncorrect'       => [
                'user'     => null,
                'id'       => 9999,
                'hasError' => true
            ],
        ];
    }
}
