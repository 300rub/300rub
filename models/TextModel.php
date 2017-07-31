<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

/**
 * Model for working with table "texts"
 *
 * @package testS\models
 */
class TextModel extends AbstractBlockModel
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

    /**
     * Sets CSS
     *
     * @param int $id
     *
     * @return TextModel
     */
    public function setCss($id = null)
    {
        if ($this->get("hasEditor") === false) {
            $this->addCss(
                $this->get("designTextModel"),
                sprintf(".block-%s", $id)
            );
        }

        $this->addCss(
            $this->get("designBlockModel"),
            sprintf(".block-%s", $id)
        );

        return $this;
    }

    /**
     * Gets HTML
     *
     * @param array $options
     *
     * @return AbstractContentModel
     *
     * @throws ModelException
     */
    public function getHtml($options = [])
    {
        $this->setCss($options["blockId"]);

        $textInstanceModel = (new TextInstanceModel())->byTextId($this->getId())->find();
        if ($textInstanceModel === null) {
            throw new ModelException(
                "Unable to find TextInstanceModel by textId: {id}",
                [
                    "id" => $this->getId()
                ]
            );
        }

        return View::get(
            "content/text",
            [
                "text" => $textInstanceModel->get("text"),
            ]
        );
    }
}