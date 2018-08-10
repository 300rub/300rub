<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
                'alias'         => 'alias',
                'title'       => 'title',
                'keywords'    => 'keywords',
                'description' => 'description',
            ],
            [
                'name'        => 'Name (Copy)',
                'alias'         => 'alias-copy',
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
                'alias'         => 'name-copy',
                'title'       => '',
                'keywords'    => '',
                'description' => '',
            ]
        );
    }
}
