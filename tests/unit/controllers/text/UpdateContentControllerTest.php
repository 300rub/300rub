<?php

namespace ss\tests\unit\controllers\text;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateContentController
 */
class UpdateContentControllerTest extends AbstractControllerTest
{

    /**
     * Test for the method updateContent
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param string $text     Text
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($user, $blockId, $text, $hasError)
    {
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

            $textInstanceModel = new TextInstanceModel();
            $textInstanceModel->set(
                [
                    'textId' => $textModel->getId(),
                    'text'   => '',
                ]
            );
            $textInstanceModel->save();

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

        $data = [
            'id'   => $requestId,
            'text' => $text,
        ];

        $this->setUser($user);
        $this->sendRequest('text', 'content', $data, 'PUT');
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();

            if ($blockId === null) {
                $blockModel->delete();
            }

            return true;
        }

        $this->assertArrayHasKey('html', $body);
        $this->assertArrayHasKey('css', $body);
        $this->assertArrayHasKey('js', $body);
        $this->assertTrue($body['result']);

        if ($text !== '') {
            $this->assertNotFalse(strpos($body['html'], $text));
        }

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
            'adminCorrect'         => [
                'user'     => self::TYPE_FULL,
                'id'       => null,
                'text'     => 'test',
                'hasError' => false
            ],
            'adminEmpty'           => [
                'user'     => self::TYPE_FULL,
                'id'       => null,
                'text'     => '',
                'hasError' => false
            ],
            'adminIncorrect'       => [
                'user'     => self::TYPE_FULL,
                'id'       => 999,
                'text'     => 'test',
                'hasError' => true
            ],
            'userCorrect'          => [
                'user'     => self::TYPE_LIMITED,
                'id'       => null,
                'text'     => 'test',
                'hasError' => false
            ],
            'userEmpty'            => [
                'user'     => self::TYPE_LIMITED,
                'id'       => null,
                'text'     => '',
                'hasError' => false
            ],
            'userIncorrect'        => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 999,
                'text'     => 'test',
                'hasError' => true
            ],
            'noOperationCorrect'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => null,
                'text'     => 'test',
                'hasError' => true
            ],
            'noOperationEmpty'     => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => null,
                'text'     => '',
                'hasError' => true
            ],
            'noOperationIncorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 999,
                'text'     => 'test',
                'hasError' => true
            ],
            'blockedCorrect'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => null,
                'text'     => 'test',
                'hasError' => true
            ],
            'blockedEmpty'         => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => null,
                'text'     => '',
                'hasError' => true
            ],
            'blockedIncorrect'     => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 999,
                'text'     => 'test',
                'hasError' => true
            ],
            'guestCorrect'         => [
                'user'     => null,
                'id'       => null,
                'text'     => 'test',
                'hasError' => true
            ],
            'guestEmpty'           => [
                'user'     => null,
                'id'       => null,
                'text'     => '',
                'hasError' => true
            ],
            'guestIncorrect'       => [
                'user'     => null,
                'id'       => 999,
                'text'     => 'test',
                'hasError' => true
            ],
        ];
    }
}
