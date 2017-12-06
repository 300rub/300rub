<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "recordClones"
 *
 * @package testS\models
 */
class RecordCloneModel extends AbstractContentModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;
    const DATE_TYPE_1 = 1;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => "",
            self::DATE_TYPE_1      => "",
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "recordClones";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "recordId"            => [
                self::FIELD_RELATION_TO_PARENT => "RecordModel"
            ],
            "coverImageId"       => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "descriptionTextId"   => [
                self::FIELD_RELATION => "TextModel"
            ],
            "designRecordCloneId" => [
                self::FIELD_RELATION => "DesignRecordCloneModel"
            ],
            "hasCover"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasCoverZoom"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasDescription"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "dateType"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "maxCount"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ]
        ];
    }

    /**
     * Gets HTML memcached key
     *
     * @param int    $id
     * @param string $uri
     * @param string $parameter
     *
     * @return string
     */
    public function getHtmlMemcachedKey($id, $uri = "", $parameter = "")
    {
        return sprintf("image_%s_html", $id);
    }

    /**
     * Gets CSS memcached key
     *
     * @param int    $id
     * @param string $uri
     *
     * @return string
     */
    public function getCssMemcachedKey($id, $uri = "")
    {
        return sprintf("image_%s_css", $id);
    }

    /**
     * Gets JS memcached key
     *
     * @param int    $id
     * @param string $uri
     *
     * @return string
     */
    public function getJsMemcachedKey($id, $uri = "")
    {
        return sprintf("image_%s_js", $id);
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        return "";
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        return [];
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
    }
}