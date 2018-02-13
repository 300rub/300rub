<?php

namespace ss\tests\unit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use ss\models\blocks\menu\MenuInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractMenuInstanceModel
 */
class AbstractMenuInstanceModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return MenuInstanceModel
     */
    protected function getNewModel()
    {
        return new MenuInstanceModel();
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'menuId'    => 1,
                    'parentId'  => null,
                    'sectionId' => 1,
                    'icon'      => 'fa-user',
                    'subName'   => 'Name',
                    'sort'      => 10,
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => null,
                    'sectionId' => 1,
                    'icon'      => 'fa-user',
                    'subName'   => 'Name',
                    'sort'      => 10,
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => 1,
                    'sectionId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                    'sort'      => 20,
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => 1,
                    'sectionId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                    'sort'      => 20,
                ]
            ]
        ];
    }
}
