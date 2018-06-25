<?php

namespace ss\tests\unit\controllers\text;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateBlockController
 */
class CreateBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test for createBlock method
     *
     * @param string $user                User type
     * @param array  $data                Data to send
     * @param bool   $hasError            Error flag
     * @param bool   $hasValidationErrors Validation errors flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $data,
        $hasError = null,
        $hasValidationErrors = null
    ) {
        $textCountBefore = TextModel::model()->getCount();
        $instanceCountBefore = new TextInstanceModel();
        $instanceCountBefore = $instanceCountBefore->getCount();
        $blockCountBefore = BlockModel::model()->getCount();

        $this->setUser($user);
        $this->sendRequest('text', 'block', $data, 'POST');
        $body = $this->getBody();

        $textModelCountAfter = TextModel::model()->getCount();
        $instanceCountAfter = new TextInstanceModel();
        $instanceCountAfter = $instanceCountAfter->getCount();
        $blockModelCountAfter = BlockModel::model()->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame($textCountBefore, $textModelCountAfter);
            $this->assertSame($instanceCountBefore, $instanceCountAfter);
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame($textCountBefore, $textModelCountAfter);
            $this->assertSame($instanceCountBefore, $instanceCountAfter);
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            'result' => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockTextModel = BlockModel::model()->getLatest();
        $textModel = $blockTextModel->getContentModel();
        $this->assertSame($data['name'], $blockTextModel->get('name'));
        $this->assertSame($data['type'], $textModel->get('type'));
        $this->assertSame($data['hasEditor'], $textModel->get('hasEditor'));

        $this->assertSame($textCountBefore, ($textModelCountAfter - 1));
        $this->assertSame($instanceCountBefore, ($instanceCountAfter - 1));
        $this->assertSame($blockCountBefore, ($blockModelCountAfter - 1));

        $blockTextModel->delete();

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
            'fullCorrect'             => [
                'user'                => self::TYPE_FULL,
                'data'                => [
                    'name'      => 'Block name',
                    'type'      => 0,
                    'hasEditor' => false,
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
