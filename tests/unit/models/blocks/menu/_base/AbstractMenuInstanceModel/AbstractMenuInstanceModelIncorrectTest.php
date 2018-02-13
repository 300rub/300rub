<?php

namespace ss\tests\unit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use ss\models\blocks\menu\MenuInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractMenuInstanceModel
 */
class AbstractMenuInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'menuId'    => 'incorrect',
                    'parentId'  => 'incorrect',
                    'sectionId' => 'incorrect',
                    'icon'      => 'incorrect',
                    'subName'   => 'incorrect',
                    'sort'      => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'menuId'    => ' 1 asd',
                    'parentId'  => 'incorrect',
                    'sectionId' => ' 1 aaaa ',
                    'icon'      => 'incorrect',
                    'subName'   => 'incorrect',
                    'sort'      => 'incorrect',
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => null,
                    'sectionId' => 1,
                    'icon'      => 'incorrect',
                    'subName'   => 'incorrect',
                    'sort'      => 0,
                ],
                [
                    'menuId'   => 2,
                    'parentId' => '1 as',
                    'icon'     => '',
                    'subName'  => '',
                ],
                [
                    'menuId'    => 1,
                    'parentId'  => 1,
                    'sectionId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                    'sort'      => 0,
                ],
            ],
            'incorrect3' => [
                [
                    'menuId'    => 1,
                    'sectionId' => 1,
                    'icon'      => '<b> icon </b>',
                ],
                [
                    'icon' => 'icon',
                ],
                [
                    'icon' => $this->generateStringWithLength(51),
                ],
                [
                    'icon' => ['maxLength'],
                ],
            ],
            'incorrect4' => [
                [
                    'menuId'    => 1,
                    'sectionId' => 1,
                    'subName'   => '<b> name </b>',
                ],
                [
                    'subName' => 'name',
                ],
                [
                    'subName' => $this->generateStringWithLength(256),
                ],
                [
                    'subName' => ['maxLength'],
                ],
            ],
        ];
    }
}
