<?php

namespace testS\tests\unit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use testS\models\blocks\menu\MenuInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractMenuInstanceModel
 */
class AbstractMenuInstanceModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'menuId'    => '',
                    'parentId'  => '',
                    'sectionId' => '',
                    'icon'      => '',
                    'subName'   => '',
                    'sort'      => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'menuId'    => 1,
                    'sectionId' => 1,
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => null,
                    'sectionId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                    'sort'      => 0,
                ],
            ],
        ];
    }
}
