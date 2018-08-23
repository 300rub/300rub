<?php

namespace ss\models\help;

use ss\application\App;

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
        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'pages',
            'pages',
            self::PK_FIELD,
            Db::DEFAULT_ALIAS,
            'pageId'
        );

        $this->getDb()->addWhere(
            'pages.alias = :alias'
        );
        $this->getDb()->addParameter('alias', $alias);

        $this->getDb()->addWhere(
            sprintf(
                '%s.language = :language',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter(
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
