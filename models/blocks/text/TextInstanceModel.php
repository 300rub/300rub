<?php

namespace ss\models\blocks\text;

use ss\application\App;
use ss\application\components\Db;
use ss\models\blocks\text\_base\AbstractTextInstanceModel;

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
