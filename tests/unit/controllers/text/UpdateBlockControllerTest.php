<?php

namespace testS\tests\unit\controllers\text;

use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextInstanceModel;
use testS\models\blocks\text\TextModel;
use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateBlockController
 */
class UpdateBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test for updateUser method
     *
     * @param string $user                user type
     * @param array  $data                Data to send
     * @param bool   $hasError            Error flag
     * @param bool   $hasValidationErrors Validation errors flag
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateBlock
     */
    public function testRun(
        $user,
        $data,
        $hasError = null,
        $hasValidationErrors = null
    ) {
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
                'text'   => 'test text',
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

        $data['id'] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest('text', 'block', $data, 'PUT');
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();
            $blockModel->delete();
            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();
            $blockModel->delete();
            return true;
        }

        $this->assertArrayHasKey('html', $body);
        $this->assertArrayHasKey('css', $body);
        $this->assertArrayHasKey('js', $body);
        $this->assertTrue($body['result']);
        $this->assertNotFalse(strpos($body['html'], 'test text'));

        $newTextModel = new TextModel();
        $newTextModel->byId($textModel->getId());
        $newTextModel = $newTextModel->find();
        $newBlockModel = new BlockModel();
        $newBlockModel = $newBlockModel->getById($blockModel->getId());

        $this->assertSame($data['name'], $newBlockModel->get('name'));
        $this->assertSame($data['type'], $newTextModel->get('type'));
        $this->assertSame($data['hasEditor'], $newTextModel->get('hasEditor'));

        $newBlockModel->delete();

        return true;
    }

    /**
     * Data provider for testUpdateBlock
     *
     * @return array
     */
    public function dataProviderForTestUpdateBlock()
    {
        return [
            'fullCorrect'             => [
                'user'                => self::TYPE_FULL,
                'data'                => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => true,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
            'fullEmptyName'           => [
                'user'                => self::TYPE_FULL,
                'data'                => [
                    'name'      => '',
                    'type'      => 0,
                    'hasEditor' => false,
                ],
                'hasError'            => false,
                'hasValidationErrors' => true,
            ],
            'fullIncorrectHasEditor'  => [
                'user'     => self::TYPE_FULL,
                'data'     => [
                    'name'      => 'Block name',
                    'type'      => 1,
                    'hasEditor' => 999,
                ],
                'hasError' => true,
            ],
            'fullIncorrectParameters' => [
                'user'     => self::TYPE_FULL,
                'data'     => [
                    'name' => 'Block name',
                ],
                'hasError' => true,
            ],
            'guest'                   => [
                'user'     => null,
                'data'     => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => false,
                ],
                'hasError' => true,
            ],
            'blocked'                 => [
                'user'     => self::TYPE_BLOCKED_USER,
                'data'     => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => false,
                ],
                'hasError' => true,
            ],
            'noOperationUser'         => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'data'     => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => false,
                ],
                'hasError' => true,
            ],
            'userCorrect'             => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => false,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
        ];
    }
}
