<?php

namespace testS\models\blocks\text;

use testS\application\App;
use testS\application\components\Db;
use testS\models\blocks\text\_abstract\AbstractTextInstanceModel;

/**
 * Model for working with table "textInstances"
 */
class TextInstanceModel extends AbstractTextInstanceModel
{

    /**
     * Finds by text ID
     *
     * @param int $textId Text ID
     *
     * @return TextInstanceModel
     */
    public function byTextId($textId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.textId = :textId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('textId', $textId);

        return $this;
    }

    /**
     * Runs after deleting
     *
     * @return void
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        $textModel = new TextModel();
        $textModel->set(['id' => $this->get('textId')]);

        App::getInstance()->getMemcached()->delete(
            $textModel->getHtmlMemcachedKey()
        );
    }

    /**
     * Runs after saving
     *
     * @return void
     */
    protected function afterSave()
    {
        parent::afterSave();

        $textModel = new TextModel();
        $textModel->set(['id' => $this->get('textId')]);

        App::getInstance()->getMemcached()->delete(
            $textModel->getHtmlMemcachedKey()
        );
    }
}
