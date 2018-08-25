<?php

namespace ss\models\help;

use ss\application\App;

use ss\application\components\db\Table;
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
        $this->getTable()->addJoin(
            Table::JOIN_TYPE_INNER,
            'categories',
            'categories',
            self::PK_FIELD,
            Table::DEFAULT_ALIAS,
            'categoryId'
        );

        $this->getTable()->addWhere(
            'categories.alias = :alias'
        );
        $this->getTable()->addParameter('alias', $alias);

        $this->getTable()->addWhere(
            sprintf(
                '%s.language = :language',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter(
            'language',
            App::getInstance()->getLanguage()->getActiveId()
        );

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
