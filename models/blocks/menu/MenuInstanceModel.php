<?php

namespace ss\models\blocks\menu;

use ss\application\App;
use ss\application\components\Db;
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
        $structure = $this->_getDbStructure($menuId);

        return $structure;
    }

    /**
     * Gets tree by menu ID
     *
     * @param integer $menuId Menu ID
     *
     * @return array
     */
    private function _getDbStructure($menuId)
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->addSelect('id', Db::DEFAULT_ALIAS, 'id')
            ->addSelect('parentId', Db::DEFAULT_ALIAS, 'parentId')
            ->addSelect('sectionId', Db::DEFAULT_ALIAS, 'sectionId')
            ->addSelect('subName', Db::DEFAULT_ALIAS, 'subName')
            ->addSelect('isMain', 'sections', 'isMain')
            ->addSelect('name', 'seo', 'name')
            ->addSelect('url', 'seo', 'url');
        $dbObject
            ->setTable('menuInstances');
        $dbObject
            ->addJoin('sections', 'sections', Db::DEFAULT_ALIAS, 'sectionId', Db::JOIN_TYPE_LEFT)
            ->addJoin('seo', 'seo', 'sections', 'seoId', Db::JOIN_TYPE_LEFT);
        $dbObject
            ->addWhere(sprintf('%s.menuId = :menuId', Db::DEFAULT_ALIAS));
        $dbObject
            ->addParameter('menuId', $menuId);
        $dbObject
            ->setOrder(sprintf('%s.sort', Db::DEFAULT_ALIAS));

        return $dbObject->findAll();
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
