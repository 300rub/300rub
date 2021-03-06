<?php

namespace ss\models\help;

use ss\application\App;

use ss\application\components\db\Table;
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
        $table = $this->getTable()
            ->addSelect('alias', 'categories', 'alias')
            ->addSelect('name', 'languageCategories', 'name')
            ->setTableName('pages')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'categories',
                'categories',
                self::PK_FIELD,
                Table::DEFAULT_ALIAS,
                'categoryId'
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'languageCategories',
                'languageCategories',
                'categoryId',
                'categories',
                self::PK_FIELD
            )
            ->addWhere('languageCategories.language = :language')
            ->addParameter(
                'language',
                App::getInstance()->getLanguage()->getActiveId()
            )
            ->addWhere(sprintf('%s.alias = :alias', Table::DEFAULT_ALIAS))
            ->addParameter('alias', $alias);

        $result = $table->find();

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
     * Gets list by category alias
     *
     * @param string $categoryAlias Category alias
     *
     * @return array
     */
    public function getListByCategoryAlias($categoryAlias)
    {
        $table = $this->getTable()
            ->addSelect('alias', Table::DEFAULT_ALIAS, 'alias')
            ->addSelect('name', 'languagePages', 'name')
            ->setTableName('pages')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'languagePages',
                'languagePages',
                'pageId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'categories',
                'categories',
                self::PK_FIELD,
                Table::DEFAULT_ALIAS,
                'categoryId'
            )
            ->addWhere(sprintf('categories.alias = :alias', $categoryAlias))
            ->addParameter('alias', $categoryAlias)
            ->addWhere('languagePages.language = :language')
            ->addParameter(
                'language',
                App::getInstance()->getLanguage()->getActiveId()
            )
            ->setOrder('languagePages.name');

        $list = [];
        $result = $table->findAll();
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

        return $list;
    }
}
