<?php

namespace testS\models;

use testS\application\App;
use testS\components\Db;

/**
 * Model for working with table "textInstances"
 *
 * @package testS\models
 */
class TextInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "textInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "textId"  => [
                self::FIELD_RELATION_TO_PARENT   => "TextModel",
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            "text"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ]
        ];
    }

    /**
     * Finds by text ID
     *
     * @param int $textId
     *
     * @return TextInstanceModel
     */
    public function byTextId($textId)
    {
        $this->getDb()->addWhere(sprintf("%s.textId = :textId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("textId", $textId);

        return $this;
    }

    /**
     * Runs after deleting
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        App::getInstance()->getMemcached()->delete(
            (new TextModel())->getHtmlMemcachedKey(
                $this->get("textId")
            )
        );
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
        parent::afterSave();

        App::getInstance()->getMemcached()->delete(
            (new TextModel())->getHtmlMemcachedKey(
                $this->get("textId")
            )
        );
    }
}