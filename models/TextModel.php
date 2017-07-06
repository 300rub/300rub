<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;

/**
 * Model for working with table "texts"
 *
 * @package testS\models
 */
class TextModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_DIV = 0;
    const TYPE_H1 = 1;
    const TYPE_H2 = 2;
    const TYPE_H3 = 3;

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_DIV => Language::t("text", "typeDefault"),
            self::TYPE_H1  => Language::t("text", "typeH1"),
            self::TYPE_H2  => Language::t("text", "typeH2"),
            self::TYPE_H3  => Language::t("text", "typeH3"),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "texts";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designTextId"  => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "designBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "type"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList(), self::TYPE_DIV]
                ],
            ],
            "hasEditor"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * After duplicate
     *
     * @param TextModel $oldModel
     */
    protected function afterDuplicate($oldModel)
    {
        $textInstanceModels = (new TextInstanceModel())->byTextId($oldModel->getId())->findAll();
        foreach ($textInstanceModels as $textInstanceModel) {
            $newTextInstanceModel = new TextInstanceModel();
            $newTextInstanceModel->set([
                "textId" => $this->getId(),
                "text"   => $textInstanceModel->get("text")
            ]);
            $newTextInstanceModel->save();
        }
    }
}