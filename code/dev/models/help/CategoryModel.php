<?php

namespace ss\models\help;

use ss\application\App;
use ss\application\components\Db;
use ss\application\exceptions\NotFoundException;
use ss\models\help\_base\AbstractCategoryModel;

/**
 * Model for working with table "category" (help DB)
 */
class CategoryModel extends AbstractCategoryModel
{

    /**
     * Type
     */
    const TYPE = 'category';

    /**
     * Gets CategoryModel
     *
     * @return CategoryModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets LanguageCategoryModel
     *
     * @throws NotFoundException
     *
     * @return LanguageCategoryModel
     */
    protected function getLanguageModel()
    {
        if ($this->languageModel === null) {
            $this->languageModel = LanguageCategoryModel::model()
                ->byAlias($this->getAlias())
                ->find();

            if ($this->languageModel === null) {
                throw new NotFoundException(
                    App::getInstance()->getLanguage()->getMessage(
                        'site',
                        'helpCategoryNotFound'
                    )
                );
            }
        }

        return $this->languageModel;
    }

    /**
     * Generates breadcrumbs
     *
     * @return array
     */
    protected function generateBreadcrumbs()
    {
        $language = App::getInstance()->getLanguage();

        $breadcrumbs = [
            [
                'name' => $language->getMessage('site', 'home'),
                'uri'  => sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
            ],
            [
                'name' => $language->getMessage('site', 'help'),
                'uri'  => sprintf(
                    '/%s/help',
                    $language->getActiveAlias()
                ),
            ],
        ];

        $breadcrumbs[] = [
            'name' => $this->getName(),
        ];

        return $breadcrumbs;
    }

    /**
     * Find by Alias
     *
     * @param string $alias Alias
     *
     * @return CategoryModel
     */
    public function byAlias($alias)
    {
        $this->getDb()->addWhere(
            sprintf('%s.alias = :alias', Db::DEFAULT_ALIAS)
        );
        $this->getDb()->addParameter('alias', $alias);

        return $this;
    }

    /**
     * Gets child categories memcached key
     *
     * @param string $alias Alias
     *
     * @return string
     */
    private function _getChildCategoriesMemcachedKey($alias)
    {
        return sprintf('help_child_categories_%s', $alias);
    }

    /**
     * Gets child categories by alias
     *
     * @param string $alias Alias
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function getChildCategories($alias = null)
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->_getChildCategoriesMemcachedKey(
            $alias
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            return $memcachedResult;
        }

        $this->setPdo();
        $language = App::getInstance()->getLanguage();

        $dbObject = App::getInstance()->getDb();

        $parentId = null;
        if ($alias !== null) {
            $model = $this->byAlias($alias)->find();
            if ($model === null) {
                throw new NotFoundException(
                    App::getInstance()->getLanguage()->getMessage(
                        'site',
                        'helpCategoryNotFound'
                    )
                );
            }
            $parentId = $model->get('parentId');
        }

        $dbObject
            ->addSelect('alias', Db::DEFAULT_ALIAS, 'alias')
            ->addSelect('name', 'languageCategories', 'name');
        $dbObject
            ->setTable('categories');
        $dbObject
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'languageCategories',
                'languageCategories',
                'categoryId',
                Db::DEFAULT_ALIAS,
                self::PK_FIELD
            );

        if ($parentId === null) {
            $dbObject
                ->addWhere(sprintf('%s.parentId IS NULL', Db::DEFAULT_ALIAS));
        }

        if ($parentId !== null) {
            $dbObject
                ->addWhere(sprintf('%s.parentId = :parentId', Db::DEFAULT_ALIAS));
            $dbObject
                ->addParameter('parentId', $parentId);
        }

        $dbObject
            ->addWhere('languageCategories.language = :language');
        $dbObject
            ->addParameter('language', $language->getActiveId());

        $dbObject
            ->setOrder('languageCategories.name');

        $list = [];
        $result = $dbObject->findAll();
        foreach ($result as $item) {
            $list[] = [
                'name' => $item['name'],
                'uri'  => sprintf(
                    '/%s/help/%s',
                    $language->getActiveAlias(),
                    $item['alias']
                ),
            ];
        }

        $memcached->set($memcachedKey, $list);

        return $list;
    }
}
