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
     * Runs after changing
     *
     * @return void
     */
    protected function afterChange()
    {
        parent::afterChange();

        $memcachedKey = sprintf(
            TextModel::CACHE_KEY_MASK,
            $this->get('textId')
        );
        $memcached = App::getInstance()->getMemcached();
        $memcached->delete($memcachedKey);
    }
}
