<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use ss\models\blocks\menu\MenuInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

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
                    'sort'      => 0,
                ],
            ],
        ];
    }
}
