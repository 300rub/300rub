<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractBlockModel;

use testS\models\blocks\block\BlockModel;
use testS\tests\unit\models\_abstract\AbstractModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelTest extends AbstractModelTest
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
     * Test for unique language - contentType - contentId
     *
     * @return void
     */
    public function testUnique()
    {
        $blockModel = $this->getNewModel()->byId(1)->find();
        $this->assertNotNull($blockModel);

        $this->expectException(self::EXCEPTION_MODEL);

        $newModel = $this->getNewModel();
        $newModel->set(
            [
                'name'        => 'New name',
                'language'    => $blockModel->get('language'),
                'contentType' => $blockModel->get('contentType'),
                'contentId'   => $blockModel->get('contentId')
            ]
        );
        $newModel->save();
    }
}
