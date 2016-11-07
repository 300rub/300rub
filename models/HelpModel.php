<?php

namespace testS\models;

/**
 * Model for working with table "help"
 *
 * @package testS\models
 *
 * @method HelpModel find
 */
class HelpModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "help";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "language" => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "category" => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "name"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "content"  => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
        ];
    }

    /**
     * Adds condition to SQL
     *
     * @param string $language Language
     * @param string $category Category
     * @param string $name     Name
     *
     * @return HelpModel
     */
    public function setParams($language, $category, $name)
    {
        $this->getDb()
            ->addWhere("language = :language")
            ->addParameter("language", $language)
            ->addWhere("category = :category")
            ->addParameter("category", $category)
            ->addWhere("name = :name")
            ->addParameter("name", $name);

        return $this;
    }
}