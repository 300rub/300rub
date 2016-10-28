<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "sections"
 *
 * @package testS\models
 *
 * @method SectionModel   byId($id)
 * @method SectionModel   find()
 * @method SectionModel[] findAll
 * @method SectionModel   exceptId($id)
 *
 * @property bool $isMain
 * @property int  $width
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
    protected function getFieldsInfo()
    {
        return [
            "language"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [Language::$aliasList, Language::$activeId]
                ],
            ],
            "width"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["minThen" => [0, self::DEFAULT_WIDTH]],
            ],
            "isMain"        => [
                self::FIELD_TYPE        => self::FIELD_TYPE_BOOL,
                self::FIELD_BEFORE_SAVE => ["setIsMain"]
            ],
            "seoId"         => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "SeoModel",
                    self::FIELD_RELATION_NAME  => "seoModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designBlockId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ]
        ];
    }

    /**
     * Adds url & language condition in SQL request
     *
     * @param string $url url раздела
     *
     * @return SectionModel
     */
    public function byUrl($url = "")
    {
        $this->withRelations();

        $this->getDb()->addWhere(sprintf("%s.language = :language", $this->getTableName()));
        $this->getDb()->addParameter("language", Language::$activeId);

        if ($url) {
            $this->getDb()->addWhere("seoModel.url = :url");
            $this->getDb()->addParameter("url", $url);
        } else {
            $this->selectMain();
        }

        return $this;
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
            $this->getDb()->update();
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

    /**
     * Gets width
     *
     * @return string
     */
    public function getWidth()
    {
        if ($this->width <= 100) {
            return sprintf("%s%", $this->width);
        }

        return sprintf("%spx", $this->width);
    }
}