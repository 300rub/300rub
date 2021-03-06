<?php

namespace ss\models\blocks\text;

use ss\application\components\db\Table;
use ss\application\exceptions\ModelException;
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
        $this->getTable()->addWhere(
            sprintf(
                '%s.textId = :textId',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('textId', $textId);

        return $this;
    }

    /**
     * Gets TextInstanceModel by text ID
     *
     * @param int $textId Text ID
     *
     * @return TextInstanceModel
     *
     * @throws ModelException
     */
    public function getByTextId($textId)
    {
        $textInstanceModel = $this
            ->byTextId($textId)
            ->find();

        if ($textInstanceModel === null) {
            throw new ModelException(
                'Unable to find TextInstanceModel by textId: {id}',
                [
                    'id' => $this->getId()
                ]
            );
        }

        return $textInstanceModel;
    }

    /**
     * Gets TextInstanceModel
     *
     * @return TextInstanceModel
     */
    public static function model()
    {
        return new self;
    }
}
