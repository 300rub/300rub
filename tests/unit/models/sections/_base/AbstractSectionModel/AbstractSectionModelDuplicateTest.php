<?php

namespace testS\tests\unit\models\sections\_base\AbstractSectionModel;

use testS\models\sections\SectionModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return SectionModel
     */
    protected function getNewModel()
    {
        return new SectionModel();
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
                'seoModel'         => [
                    'name'        => 'name',
                    'url'         => 'url',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description'
                ],
                'designBlockModel' => [
                    'marginTop'    => 10,
                    'marginBottom' => 20,
                ],
                'language'         => 1,
                'isMain'           => false
            ],
            [
                'seoModel'         => [
                    'name'        => 'name (Copy)',
                    'url'         => 'url-copy',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
                'designBlockModel' => [
                    'marginTop'    => 10,
                    'marginBottom' => 20,
                ],
                'language'         => 1,
                'isMain'           => false
            ]
        );
    }
}
