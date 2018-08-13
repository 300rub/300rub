<?php

namespace ss\models\help;

use ss\application\App;
use ss\application\components\Db;
use ss\application\exceptions\NotFoundException;
use ss\models\help\_base\AbstractPageModel;

/**
 * Model for working with table "pages" (help DB)
 */
class PageModel extends AbstractPageModel
{

    /**
     * Type
     */
    const TYPE = 'page';

    /**
     * Gets PageModel
     *
     * @return PageModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets AbstractPageModel
     *
     * @throws NotFoundException
     *
     * @return AbstractPageModel
     */
    protected function getLanguageModel()
    {
        if ($this->languageModel === null) {
            $this->languageModel = LanguagePageModel::model()
                ->byAlias($this->getAlias())
                ->find();

            if ($this->languageModel === null) {
                throw new NotFoundException(
                    App::getInstance()->getLanguage()->getMessage(
                        'site',
                        'helpPageNotFound'
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
     */
    public function generateBreadcrumbs($alias, $name)
    {
        $dbObject = App::getInstance()->getDb();
        $language = App::getInstance()->getLanguage();

        $dbObject
            ->addSelect('alias', 'categories', 'alias')
            ->addSelect('name', 'languageCategories', 'name');
        $dbObject
            ->setTable('pages');
        $dbObject
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'categories',
                'categories',
                self::PK_FIELD,
                Db::DEFAULT_ALIAS,
                'categoryId'
            )
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'languageCategories',
                'languageCategories',
                'categoryId',
                'categories',
                self::PK_FIELD
            );

        $dbObject
            ->addWhere('languageCategories.language = :language');
        $dbObject
            ->addParameter(
                'language',
                $language->getActiveId()
            );

        $dbObject
            ->addWhere(sprintf('%s.alias = :alias', Db::DEFAULT_ALIAS));
        $dbObject
            ->addParameter('alias', $alias);

        $result = $dbObject->find();

        $breadcrumbs = CategoryModel::model()
            ->setBaseUri($this->getBaseUri())
            ->generateBreadcrumbs(
                $result['alias'],
                $result['name']
            );

        $breadcrumbs[(count($breadcrumbs) - 1)]['uri'] = sprintf(
            '%s/%s',
            $this->getBaseUri(),
            $result['alias']
        );

        $breadcrumbs[] = [
            'name' => $name,
        ];

        return $breadcrumbs;
    }

    /**
     * Gets child categories memcached key
     *
     * @param string $alias Alias
     *
     * @return string
     */
    private function _getListMemcachedKey($alias)
    {
        return sprintf(
            'help_pages_list_%s_%s',
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Gets list by category alias
     *
     * @param string $categoryAlias Category alias
     *
     * @return array
     */
    public function getListByCategoryAlias($categoryAlias)
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->_getListMemcachedKey(
            $categoryAlias
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            return $memcachedResult;
        }

        $dbObject = App::getInstance()->getDb();
        $language = App::getInstance()->getLanguage();

        $dbObject
            ->addSelect('alias', Db::DEFAULT_ALIAS, 'alias')
            ->addSelect('name', 'languagePages', 'name');
        $dbObject
            ->setTable('pages');
        $dbObject
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'languagePages',
                'languagePages',
                'pageId',
                Db::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'categories',
                'categories',
                self::PK_FIELD,
                Db::DEFAULT_ALIAS,
                'categoryId'
            );

        $dbObject
            ->addWhere(sprintf('categories.alias = :alias', $categoryAlias));
        $dbObject
            ->addParameter('alias', $categoryAlias);

        $dbObject
            ->addWhere('languagePages.language = :language');
        $dbObject
            ->addParameter(
                'language',
                $language->getActiveId()
            );

        $dbObject
            ->setOrder('languagePages.name');

        $list = [];
        $result = $dbObject->findAll();
        foreach ($result as $item) {
            $list[] = [
                'name' => $item['name'],
                'uri'  => sprintf(
                    '%s/%s/%s',
                    $this->getBaseUri(),
                    $categoryAlias,
                    $item['alias']
                ),
            ];
        }

        $memcached->set($memcachedKey, $list);

        return $list;
    }
}
