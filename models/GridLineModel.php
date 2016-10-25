<?php

namespace testS\models;

/**
 * Model for working with table "gridLines"
 *
 * @package testS\models
 *
 * @property int $sort
 * @property int $sectionId
 *
 * @method GridLineModel[] findAll()
 * @method GridLineModel   byId($id)
 * @method GridLineModel   find()
 * @method GridLineModel   withRelations()
 */
class GridLineModel extends AbstractModel
{

    /**
     * Gets model object
     *
     * @return GridLineModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "gridLines";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "sectionId"       => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "SectionModel",
                    self::FIELD_RELATION_NAME  => "sectionModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_HAS_ONE
                ]
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "outsideDesignId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "outsideDesignModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "insideDesignId"  => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "insideDesignModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ]
        ];
    }

    /**
     * Adds section ID to SQL request
     *
     * @param int $sectionId Section ID
     *
     * @return GridLineModel
     */
    public function bySectionId($sectionId = null)
    {
        if ($sectionId) {
            $this->getDb()
                ->addWhere("sectionId = :sectionId")
                ->addParameter("sectionId", $sectionId);
        }

        return $this;
    }

    /**
     * Adds order by sort to SQL request
     *
     * @return GridLineModel
     */
    public function ordered()
    {
        $this->getDb()->setOrder("sort");
        return $this;
    }
}