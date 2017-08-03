<?php

namespace testS\models;

use testS\applications\App;
use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

/**
 * Model for working with table "texts"
 *
 * @package testS\models
 */
class TextModel extends AbstractContentModel
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
        return sprintf("text_%s_html", $id);
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
        return sprintf("text_%s_css", $id);
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
        return sprintf("text_%s_js", $id);
    }

    /**
     * Generates HTML
     *
     * @return string
     *
     * @throws ModelException
     */
    public function generateHtml()
    {
        $memcached = App::getInstance()->getMemcached();
        $htmlMemcachedKey = $this->getHtmlMemcachedKey($this->getContentId());
        $htmlMemcachedValue = $memcached->get($htmlMemcachedKey);

        if ($htmlMemcachedValue !== false) {
            return $htmlMemcachedValue;
        }

        $textInstanceModel = (new TextInstanceModel())->byTextId($this->getContentId())->find();
        if ($textInstanceModel === null) {
            throw new ModelException(
                "Unable to find TextInstanceModel by textId: {id}",
                [
                    "id" => $this->getId()
                ]
            );
        }

        $html = View::get(
            "content/text",
            [
                "blockId" => $this->getBlockId(),
                "text"    => $textInstanceModel->get("text"),
            ]
        );

        $memcached->set($htmlMemcachedKey, $html);

        return $html;
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $css = [];

        if ($this->get("hasEditor") === false) {
            $css = array_merge(
                $css,
                View::generateCss(
                    $this->get("designTextModel"),
                    sprintf(".block-%s", $this->getBlockId())
                )
            );
        }

        $css = array_merge(
            $css,
            View::generateCss(
                $this->get("designBlockModel"),
                sprintf(".block-%s", $this->getBlockId())
            )
        );

        return $css;
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

    /**
     * Runs after deleting
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        $memcached = App::getInstance()->getMemcached();
        $memcached
            ->delete($this->getHtmlMemcachedKey($this->getId()))
            ->delete($this->getCssMemcachedKey($this->getId()))
            ->delete($this->getJsMemcachedKey($this->getId()));
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
        parent::afterSave();

        $memcached = App::getInstance()->getMemcached();
        $memcached
            ->delete($this->getCssMemcachedKey($this->getId()))
            ->delete($this->getJsMemcachedKey($this->getId()));
    }
}