<?php

namespace ss\tests\phpunit\controllers\text;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\block\DesignBlockModel;
use ss\models\blocks\text\DesignTextModel;
use ss\models\blocks\text\TextModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateDesignController
 */
class UpdateDesignControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param array  $data     Data
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($user, $blockId, $data, $hasError)
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

        $this->setUser($user);
        $this->sendRequest(
            'text',
            'design',
            array_merge(
                $data,
                [
                    'blockId' => $requestId
                ]
            ),
            'PUT'
        );
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();

            if ($blockId === null) {
                $blockModel->delete();
            }

            return true;
        }

        $this->assertTrue($body['result']);

        $designBlockModel = new DesignBlockModel();
        $designBlockModel->latest();
        $designBlockModel = $designBlockModel->find();
        $this->compareExpectedAndActual(
            $data['designBlockModel'],
            $designBlockModel->get()
        );

        $designTextModel = new DesignTextModel();
        $designTextModel->latest();
        $designTextModel = $designTextModel->find();
        $this->compareExpectedAndActual(
            $data['designTextModel'],
            $designTextModel->get()
        );

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
            'adminCorrect'        => [
                'user'     => self::TYPE_FULL,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => false
            ],
            'adminIncorrectId'    => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 9999,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => true
            ],
            'adminIncorrectData'  => [
                'user'     => self::TYPE_FULL,
                'blockId'  => null,
                'data'     => [
                    'designTextModel' => [
                        'marginTop' => 10
                    ],
                ],
                'hasError' => true
            ],
            'userCorrect'         => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => false
            ],
            'noOperationsCorrect' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => true
            ],
            'blockedCorrect'      => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => true
            ],
            'guestCorrect'        => [
                'user'     => null,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                    'designTextModel'  => [
                        'size' => 20
                    ]
                ],
                'hasError' => true
            ],
        ];
    }
}
