<?php

namespace ss\models\blocks\menu;

use ss\application\App;
use ss\models\blocks\menu\_base\AbstractMenuInstanceModel;

/**
 * Model for working with table "menuInstances"
 */
class MenuInstanceModel extends AbstractMenuInstanceModel
{

    /**
     * Gets tree by menu ID
     *
     * @param integer $menuId Menu ID
     *
     * @return array
     */
    public function getTreeByMenuId($menuId)
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->addSelect('id', 'menuInstances', 'id')
            ->addSelect('parentId', 'menuInstances', 'parentId')
            ->addSelect('sectionId', 'menuInstances', 'sectionId')
            ->addSelect('subName', 'menuInstances', 'subName')
            ->setTable('menuInstances')
        ;

        return [];
    }

    /**
     * Gets model
     *
     * @return MenuInstanceModel
     */
    public static function model()
    {
        return new self;
    }
}
