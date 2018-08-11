<?php

namespace ss\models\help;

use ss\application\components\Db;
use ss\models\help\_base\AbstractLanguageCategoryModel;

/**
 * Model for working with table "languageCategories" (help DB)
 */
class LanguageCategoryModel extends AbstractLanguageCategoryModel
{

    /**
     * Find by Alias
     *
     * @param string $alias Alias
     *
     * @return LanguageCategoryModel
     */
    public function byAlias($alias)
    {
        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'categories',
            'categories',
            self::PK_FIELD,
            Db::DEFAULT_ALIAS,
            'categoryId'
        );

        $this->getDb()->addWhere(
            'categories.alias = :alias'
        );
        $this->getDb()->addParameter('alias', $alias);

        return $this;
    }

    /**
     * Gets LanguageCategoryModel
     *
     * @return LanguageCategoryModel
     */
    public static function model()
    {
        return new self;
    }
}
