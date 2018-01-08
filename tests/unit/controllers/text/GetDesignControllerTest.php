<?php

namespace testS\tests\unit\controllers\text;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetDesignController
 */
class GetDesignControllerTest extends AbstractControllerTest
{

    /**
     * Test for get design method
     *
     * @param string $user              User type
     * @param int    $blockId           Block ID
     * @param bool   $hasError          Error flag
     * @param array  $expectedBlockData Expected block data
     * @param array  $expectedTextData  Expected text data
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetDesign
     */
    public function testGetDesign(
        $user,
        $blockId,
        $hasError,
        $expectedBlockData = [],
        $expectedTextData = []
    ) {
        $this->setUser($user);
        $this->sendRequest('text', 'design', ['id' => $blockId]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expected = [
            'id'          => $blockId,
            'controller'  => 'text',
            'action'      => 'design',
            'title'       => 'Text design',
            'description' => "You can configure text's design",
            'list'        => [
                [
                    'title' => 'Text design',
                    'data'  => [
                        [
                            'selector'  => sprintf('.block-%s', $blockId),
                            'id'        => sprintf('block-%s-block', $blockId),
                            'type'      => 'block',
                            'title'     => 'Block design',
                            'namespace' => 'designBlockModel',
                            'labels'    => [
                                'margin' => 'Margin',
                            ],
                            'values'    => $expectedBlockData,
                        ],
                        [
                            'selector'  => sprintf('.block-%s', $blockId),
                            'id'        => sprintf('block-%s-text', $blockId),
                            'type'      => 'text',
                            'title'     => 'Text design',
                            'namespace' => 'designTextModel',
                            'labels'    => [
                                'mouseHoverEffect' => 'Mouse-over effect',
                            ],
                            'values'    => $expectedTextData
                        ]
                    ]
                ]
            ],
            'button'      => [
                'label' => 'Save',
            ],
        ];

        $this->compareExpectedAndActual($expected, $body);

        return true;
    }

    /**
     * Data provider for testGetDesign
     *
     * @return array
     */
    public function dataProviderForTestGetDesign()
    {
        return [
            'admin1'         => [
                'user'              => self::TYPE_FULL,
                'blockId'           => 1,
                'hasError'          => false,
                'expectedBlockData' => [
                    'marginTop' => 0
                ],
                'expectedTextData'  => [
                    'size' => 14
                ],
            ],
            'admin0'         => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 0,
                'hasError' => true
            ],
            'admin999'       => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 999,
                'hasError' => true
            ],
            'user1'          => [
                'user'              => self::TYPE_LIMITED,
                'blockId'           => 1,
                'hasError'          => false,
                'expectedBlockData' => [
                    'marginBottom' => 0
                ],
                'expectedTextData'  => [
                    'family' => 0
                ],
            ],
            'user0'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 0,
                'hasError' => true
            ],
            'user999'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 999,
                'hasError' => true
            ],
            'blocked1'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 1,
                'hasError' => true
            ],
            'blocked0'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 0,
                'hasError' => true
            ],
            'blocked999'     => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 999,
                'hasError' => true
            ],
            'noOperation1'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 1,
                'hasError' => true
            ],
            'noOperation0'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 0,
                'hasError' => true
            ],
            'noOperation999' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 999,
                'hasError' => true
            ],
            'guest1'         => [
                'user'     => null,
                'blockId'  => 1,
                'hasError' => true
            ],
            'guest0'         => [
                'user'     => null,
                'blockId'  => 0,
                'hasError' => true
            ],
            'guest999'       => [
                'user'     => null,
                'blockId'  => 999,
                'hasError' => true
            ],
        ];
    }
}
