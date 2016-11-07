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
 * @method GridLineModel   ordered($value)
 */
class GridLineModel extends AbstractModel
{

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
    public function getFieldsInfo()
    {
        return [
            "outsideDesignId" => [
                self::FIELD_RELATION => ["DesignBlockModel", "outsideDesignModel"]
            ],
            "insideDesignId"  => [
                self::FIELD_RELATION => ["DesignBlockModel", "insideDesignModel"]
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "sectionId"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
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
}