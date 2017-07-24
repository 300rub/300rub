<?php

namespace testS\models;

/**
 * Model for working with table "gridLines"
 *
 * @method GridLineModel   withRelations()
 * @method GridLineModel   ordered($type)
 * @method GridLineModel[] findAll()
 *
 * @package testS\models
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
            "sectionId"       => [
                self::FIELD_RELATION_TO_PARENT => "SectionModel",
            ],
            "outsideDesignId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "insideDesignId"  => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
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