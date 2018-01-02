<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractBlockModel;

use testS\models\_abstract\AbstractModel;
use testS\models\blocks\block\BlockModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Gets model by ID
     *
     * @param integer $modelId ID
     *
     * @return BlockModel|AbstractModel
     */
    private function _getModelById($modelId)
    {
        return $this->getNewModel()->byId($modelId)->find();
    }

    /**
     * Duplicates model
     *
     * @param BlockModel $modelForCopy Model to copy
     *
     * @return BlockModel|AbstractModel
     */
    private function _duplicate($modelForCopy)
    {
        return $modelForCopy->duplicate();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $modelForCopy = $this->_getModelById(1);
        $duplicatedModel = $this->_duplicate($modelForCopy);

        $this->assertNotSame(
            $modelForCopy->getId(),
            $duplicatedModel->getId()
        );
        $this->assertSame(
            $modelForCopy->get('name') . ' (Copy)',
            $duplicatedModel->get('name')
        );
        $this->assertSame(
            $modelForCopy->get('language'),
            $duplicatedModel->get('language')
        );
        $this->assertSame(
            $modelForCopy->get('contentType'),
            $duplicatedModel->get('contentType')
        );
        $this->assertNotSame(
            $modelForCopy->get('contentId'),
            $duplicatedModel->get('contentId')
        );

        $contentModelForCopy = $modelForCopy->getContentModel();
        $copiedContentModel = $duplicatedModel->getContentModel();
        $this->assertNotSame(
            $contentModelForCopy->getId(),
            $copiedContentModel->getId()
        );

        $duplicatedModel->delete();
        $this->assertNull(
            $copiedContentModel
                ->byId($copiedContentModel->getId())
                ->find()
        );
    }
}
