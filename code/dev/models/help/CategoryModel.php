<?php

namespace ss\models\help;

use ss\application\App;

use ss\application\components\db\Table;
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
     * Parent breadcrumbs
     *
     * @var array
     */
    private $_parentBreadcrumbs = [];

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
     * @param string $alias Alias
     * @param string $name  Name
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function generateBreadcrumbs($alias, $name)
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
                'uri'  => $this->getBaseUri(),
            ],
        ];

        $model = $this->byAlias($alias)->find();
        if ($model === null) {
            throw new NotFoundException(
                App::getInstance()->getLanguage()->getMessage(
                    'site',
                    'helpCategoryNotFound'
                )
            );
        }

        $this->_setParentBreadcrumbs($model->get('parentId'));

        if (count($this->_parentBreadcrumbs) > 0) {
            $breadcrumbs = array_merge($breadcrumbs, $this->_parentBreadcrumbs);
        }

        $breadcrumbs[] = [
            'name' => $name,
        ];

        return $breadcrumbs;
    }

    /**
     * Sets parent breadcrumbs
     *
     * @param int $parentId Parent ID
     *
     * @return CategoryModel
     */
    private function _setParentBreadcrumbs($parentId)
    {
        if ($parentId === null) {
            return $this;
        }

        $table = $this->getTable()
            ->addSelect('alias', Table::DEFAULT_ALIAS, 'alias')
            ->addSelect('parentId', Table::DEFAULT_ALIAS, 'parentId')
            ->addSelect('name', 'languageCategories', 'name')
            ->setTableName('categories')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'languageCategories',
                'languageCategories',
                'categoryId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addWhere(sprintf('%s.id = :id', Table::DEFAULT_ALIAS))
            ->addParameter('id', $parentId)
            ->addWhere('languageCategories.language = :language')
            ->addParameter(
                'language',
                App::getInstance()->getLanguage()->getActiveId()
            );

        $result = $table->find();

        array_unshift(
            $this->_parentBreadcrumbs,
            [
                'name' => $result['name'],
                'uri'  => sprintf(
                    '%s/%s',
                    $this->getBaseUri(),
                    $result['alias']
                ),
            ]
        );

        $this->_setParentBreadcrumbs($result['parentId']);

        return $this;
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
        $this->getTable()->addWhere(
            sprintf('%s.alias = :alias', Table::DEFAULT_ALIAS)
        );
        $this->getTable()->addParameter('alias', $alias);

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
        return sprintf(
            'help_child_categories_%s_%s',
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
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

            $parentId = $model->getId();
        }

        $table = $this->getTable()
            ->addSelect('alias', Table::DEFAULT_ALIAS, 'alias')
            ->addSelect('name', 'languageCategories', 'name')
            ->setTableName('categories')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'languageCategories',
                'languageCategories',
                'categoryId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            );

        if ($parentId === null) {
            $table->addWhere(
                sprintf('%s.parentId IS NULL', Table::DEFAULT_ALIAS)
            );
        }

        if ($parentId !== null) {
            $table->addWhere(
                sprintf('%s.parentId = :parentId', Table::DEFAULT_ALIAS)
            );
            $table->addParameter('parentId', $parentId);
        }

        $table
            ->addWhere('languageCategories.language = :language')
            ->addParameter(
                'language',
                App::getInstance()->getLanguage()->getActiveId()
            )
            ->setOrder('languageCategories.name');

        $list = [];
        $result = $table->findAll();
        foreach ($result as $item) {
            $list[] = [
                'name' => $item['name'],
                'uri'  => sprintf(
                    '%s/%s',
                    $this->getBaseUri(),
                    $item['alias']
                ),
            ];
        }

        $memcached->set($memcachedKey, $list);

        return $list;
    }
}
