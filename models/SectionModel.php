<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "sections"
 *
 * @package testS\models
 *
 * @property bool $isMain
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
                self::FIELD_RELATION => ["SeoModel"]
            ],
            "designBlockId" => [
                self::FIELD_RELATION => ["DesignBlockModel"]
            ],
            "language"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [Language::$aliasList, Language::$activeId]
                ],
            ],
            "isMain"        => [
                self::FIELD_TYPE        => self::FIELD_TYPE_BOOL,
                self::FIELD_BEFORE_SAVE => [
                    "setIsMain"
                ]
            ]
        ];
    }

    /**
     * Adds isMain condition in SQL request
     *
     * @return SectionModel
     */
    public function selectMain()
    {
        $this->getDb()->addWhere(sprintf("%s.isMain = :isMain", $this->getTableName()));
        $this->getDb()->addParameter("isMain", 1);
        return $this;
    }

    /**
     * Sets isMain
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function setIsMain($value)
    {
        if ($value === true) {
            $this->getDb()
                ->addField("isMain")
                ->addParameter("isMain", 0)
                ->setWhere("id > 0")
                ->update();
        } elseif (!$this->selectMain()->exceptId($this->id)->find()) {
            $value = true;
        }

        return $value;
    }

    /**
     * Runs after delete
     *
     * @throws ModelException
     */
    protected function afterDelete()
    {
        if ($this->isMain === true) {
            $model = $this->exceptId($this->id)->find();
            if ($model !== null) {
                $model->setFields(["isMain" => true])->save();
            }
        }

        parent::afterDelete();
    }
}