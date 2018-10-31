<?php

namespace ss\models\help;

use ss\application\App;

use ss\application\components\db\Table;
use ss\models\help\_base\AbstractLanguagePageModel;

/**
 * Model for working with table "languagePages" (help DB)
 */
class LanguagePageModel extends AbstractLanguagePageModel
{

    /**
     * Find by Alias
     *
     * @param string $alias Alias
     *
     * @return LanguagePageModel
     */
    public function byAlias($alias)
    {
        $this->getTable()->addJoin(
            Table::JOIN_TYPE_INNER,
            'pages',
            'pages',
            self::PK_FIELD,
            Table::DEFAULT_ALIAS,
            'pageId'
        );

        $this->getTable()->addWhere(
            'pages.alias = :alias'
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
     * Gets LanguagePageModel
     *
     * @return LanguagePageModel
     */
    public static function model()
    {
        return new self;
    }
}
