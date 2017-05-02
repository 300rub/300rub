<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;

/**
 * Model for working with table "sections"
 *
 * @package testS\models
 */
class SectionModel extends AbstractModel
{

    /**
     * Default page with in px
     */
    const DEFAULT_WIDTH = 980;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "sections";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "seoId"         => [
                self::FIELD_RELATION => "SeoModel"
            ],
            "designBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "language"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [Language::$aliasList, Language::getActiveId()]
                ],
            ],
            "isMain"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ]
        ];
    }

    /**
     * Order by name
     *
     * @return SectionModel
     */
    public function ordered()
    {
        $this->getDb()->setOrder(sprintf("%s.name", "seoModel"));

        return $this;
    }
}