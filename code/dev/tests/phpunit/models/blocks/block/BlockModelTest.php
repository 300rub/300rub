<?php

namespace ss\tests\phpunit\models\blocks\block;

use ss\models\blocks\block\BlockModel;
use ss\tests\phpunit\models\_abstract\AbstractModelTest;

/**
 * Tests for the model BlockModel
 */
class BlockModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return BlockModel
     */
    protected function getNewModel()
    {
        return new BlockModel();
    }

    /**
     * Test for getting blocks by contentType
     *
     * @param int  $contentType Content type
     * @param bool $hasResults  Flag of results
     *
     * @dataProvider dataProviderForTestFindByContentType
     *
     * @return void
     */
    public function testFindByContentType($contentType, $hasResults)
    {
        $blockModels = $this->getNewModel()
            ->byContentType($contentType)
            ->findAll();
        $this->assertSame($hasResults, count($blockModels) > 0);
    }

    /**
     * Data provider for testFindByContentType
     *
     * @return array
     */
    public function dataProviderForTestFindByContentType()
    {
        return [
            [1, true],
            [999, false],
            [0, false],
            [-10, false],
        ];
    }

    /**
     * Test for getting blocks
     *
     * @param int  $contentType Content type
     * @param int  $language    Language ID
     * @param int  $sectionId   Section ID
     * @param bool $hasResult   Flag of results
     *
     * @dataProvider dataProviderForTestGetBlocks
     *
     * @return void
     */
    public function testGetBlocks(
        $contentType,
        $language,
        $sectionId,
        $hasResult
    ) {
        $blockModels = $this->getNewModel()
            ->byContentType($contentType)
            ->byLanguage($language);

        if ($sectionId !== null) {
            $blockModels->bySectionId($sectionId);
        }

        $blockModels = $blockModels->findAll();

        $this->assertSame($hasResult, count($blockModels) > 0);
    }

    /**
     * Data provider for testGetBlocks
     *
     * @return array
     */
    public function dataProviderForTestGetBlocks()
    {
        return [
            [
                1,
                1,
                null,
                true
            ],
            [
                1,
                1,
                0,
                true
            ],
            [
                1,
                1,
                1,
                true
            ],
            [
                1,
                1,
                999,
                false
            ],
            [
                999,
                1,
                null,
                false
            ],
            [
                1,
                999,
                null,
                false
            ],
        ];
    }
}
