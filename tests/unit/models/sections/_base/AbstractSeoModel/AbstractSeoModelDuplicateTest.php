<?php

namespace ss\tests\unit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model SeoModel
 */
class AbstractSeoModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'name'        => 'Name',
                'url'         => 'url',
                'title'       => 'title',
                'keywords'    => 'keywords',
                'description' => 'description',
            ],
            [
                'name'        => 'Name (Copy)',
                'url'         => 'url-copy',
                'title'       => '',
                'keywords'    => '',
                'description' => '',
            ]
        );

        $this->duplicate(
            [
                'name' => 'Name',
            ],
            [
                'name'        => 'Name (Copy)',
                'url'         => 'name-copy',
                'title'       => '',
                'keywords'    => '',
                'description' => '',
            ]
        );
    }
}
