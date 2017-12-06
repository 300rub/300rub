<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "records"
 *
 * @package testS\models
 */
class RecordModel extends AbstractContentModel
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
        return "records";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "coverImageId"     => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "imagesImageId"    => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "descriptionTextId" => [
                self::FIELD_RELATION => "TextModel"
            ],
            "textTextId"        => [
                self::FIELD_RELATION => "TextModel"
            ],
            "designRecordsId"   => [
                self::FIELD_RELATION => "DesignRecordModel"
            ],
            "hasCover"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasImages"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasCoverZoom"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasDescription"    => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasAutoload"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "shortCardDateType" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "fullCardDateType"  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
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