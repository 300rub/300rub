<?php

namespace testS\models;

use testS\components\Db;
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
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_BEFORE_SAVE      => ["generateIsMain"]
            ],
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

    /**
     * Adds isMain = 1 condition to SQL request
     *
     * @param int $language
     *
     * @return UserModel
     */
    public function main($language = null)
    {
        if ($language === null) {
            $language = Language::getActiveId();
        }

        $this->getDb()->addWhere(sprintf("%s.isMain = :isMain", Db::DEFAULT_ALIAS));
        $this->getDb()->addWhere(sprintf("%s.language = :language", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("isMain", 1);
        $this->getDb()->addParameter("language", $language);

        return $this;
    }

    /**
     * Generates isMain
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function generateIsMain($value)
    {
        if ($value !== true) {
            return false;
        }

        return $this->main($this->get("language"))->find() === null;
    }
}