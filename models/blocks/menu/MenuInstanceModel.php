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
        $groupByParent = [];
        foreach ($structure as $instance) {
            $groupByParent[(int)$instance['parentId']][] = $instance;
        }

        return $this->_generateTree($groupByParent, 0);
    }

    /**
     * Generates tree
     *
     * @param array   $groupByParent Group by parent
     * @param integer $parentId      Parent ID
     *
     * @return array
     */
    private function _generateTree($groupByParent, $parentId)
    {
        if (array_key_exists($parentId, $groupByParent) === false) {
            return [];
        }

        $tree = [];

        foreach ($groupByParent[$parentId] as $instance) {
            $tree[] = [
                'name'     => $this->_generateName($instance),
                'url'      => $this->_generateUrl($instance),
                'isActive' => $this->_isActive($instance),
                'children' => $this->_generateTree($groupByParent, $instance['id'])
            ];
        }

        return $tree;
    }

    /**
     * Gets isActive flag
     *
     * @param array $instance Data
     *
     * @return bool
     */
    private function _isActive($instance)
    {
        $requestUri = App::getInstance()->getSite()->getUri();

        if (strlen($requestUri) === 0
            || strpos($requestUri, '/') === false
        ) {
            return (bool)$instance['isMain'];
        }

        $explode = explode('/', $requestUri);

        if ($explode[1] === $instance['url']) {
            return true;
        }

        return false;
    }

    /**
     * Generates name
     *
     * @param array $instance Data
     *
     * @return string
     */
    private function _generateName($instance)
    {
        return $instance['name'];
    }

    /**
     * Generates URL
     *
     * @param array $instance Data
     *
     * @return string
     */
    private function _generateUrl($instance)
    {
        $languageId = (int)$instance['language'];
        $language = App::getInstance()->getLanguage()->getAliasById($languageId);

        if ((bool)$instance['isMain'] === true) {
            if ($languageId === App::getInstance()->getSite()->get('language')) {
                return '/';
            }

            return sprintf('/%s', $language);
        }

        return sprintf('/%s/%s', $language, $instance['url']);
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
            ->addSelect('language', 'sections', 'language')
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
