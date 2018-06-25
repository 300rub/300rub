<?php

namespace ss\tests\unit\controllers\text;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

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
            'text',
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

        $textModel = $blockModel->getContentModel();
        $this->assertTrue($textModel instanceof TextModel);

        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel->byTextId($textModel->getId());
        $textInstanceModel = $textInstanceModel->find();
        $this->assertTrue($textInstanceModel instanceof TextInstanceModel);

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
                'id'       => 1,
                'hasError' => false,
            ],
            'fullIncorrect'        => [
                'user'     => self::TYPE_FULL,
                'id'       => 9999,
                'hasError' => true
            ],
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 1,
                'hasError' => false,
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 9999,
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 1,
                'hasError' => true
            ],
            'blockedIncorrect'     => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 9999,
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 1,
                'hasError' => true
            ],
            'noOperationIncorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 9999,
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'id'       => 1,
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
