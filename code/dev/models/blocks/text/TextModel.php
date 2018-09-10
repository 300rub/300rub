<?php

namespace ss\models\blocks\text;

use ss\models\blocks\text\_content\AbstractContentTextModel;

/**
 * Model for working with table "texts"
 */
class TextModel extends AbstractContentTextModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\text\\TextModel';

    /**
     * Gets TextModel
     *
     * @return TextModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * After duplicate
     *
     * @return void
     */
    protected function afterDuplicate()
    {
        $textInstanceModels = new TextInstanceModel();
        $textInstanceModels->byTextId($this->getDuplicateId());
        $textInstanceModels = $textInstanceModels->findAll();

        foreach ($textInstanceModels as $textInstanceModel) {
            $newTextInstanceModel = new TextInstanceModel();
            $newTextInstanceModel->set(
                [
                    'textId' => $this->getId(),
                    'text'   => $textInstanceModel->get('text')
                ]
            );
            $newTextInstanceModel->save();
        }
    }

    /**
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        parent::beforeSave();

        if ($this->get('type') !== self::TYPE_DIV) {
            $this->set(['hasEditor' => false]);
        }
    }
}
