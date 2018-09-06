<?php

namespace ss\models\blocks\menu;

use ss\application\App;

use ss\application\components\db\Table;
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
                'children' => $this->_generateTree(
                    $groupByParent,
                    $instance['id']
                )
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

        if ($explode[1] === $instance['alias']) {
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
        $staticName = trim($instance['staticName']);
        if ($staticName !== '') {
            return $staticName;
        }

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
        $alias = $instance['alias'];
        if ($alias === null) {
            return null;
        }

        $staticUrl = trim($instance['staticUrl']);
        if ($staticUrl !== '') {
            return $staticUrl;
        }

        $langId = (int)$instance['language'];
        $language = App::getInstance()->getLanguage()->getAliasById($langId);

        if ((bool)$instance['isMain'] === true) {
            if ($langId === App::getInstance()->getSite()->get('language')) {
                return '/';
            }

            return sprintf('/%s', $language);
        }

        return sprintf('/%s/%s', $language, $alias);
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
        return $this->getTable()
            ->addSelect('id', Table::DEFAULT_ALIAS, 'id')
            ->addSelect('parentId', Table::DEFAULT_ALIAS, 'parentId')
            ->addSelect('sectionId', Table::DEFAULT_ALIAS, 'sectionId')
            ->addSelect('staticName', Table::DEFAULT_ALIAS, 'staticName')
            ->addSelect('staticUrl', Table::DEFAULT_ALIAS, 'staticUrl')
            ->addSelect('language', 'sections', 'language')
            ->addSelect('isMain', 'sections', 'isMain')
            ->addSelect('name', 'seo', 'name')
            ->addSelect('alias', 'seo', 'alias')
            ->addJoin(
                Table::JOIN_TYPE_LEFT,
                'sections',
                'sections',
                self::PK_FIELD,
                Table::DEFAULT_ALIAS,
                'sectionId'
            )
            ->addJoin(
                Table::JOIN_TYPE_LEFT,
                'seo',
                'seo',
                self::PK_FIELD,
                'sections',
                'seoId'
            )
            ->addWhere(sprintf('%s.menuId = :menuId', Table::DEFAULT_ALIAS))
            ->addParameter('menuId', $menuId)
            ->setOrder(sprintf('%s.sort', Table::DEFAULT_ALIAS))
            ->findAll();
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
