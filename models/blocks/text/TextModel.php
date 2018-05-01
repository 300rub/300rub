<?php

namespace ss\models\blocks\text;

use ss\application\App;
use ss\application\exceptions\ModelException;
use ss\models\blocks\text\_base\AbstractTextModel;

/**
 * Model for working with table "texts"
 */
class TextModel extends AbstractTextModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\text\\TextModel';

    /**
     * Gets cache type
     *
     * @return integer
     */
    public function getCacheType()
    {
        return self::FULLY_CACHED;
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
        return App::getInstance()->getView()->get(
            'content/text/text',
            [
                'blockId' => $this->getBlockId(),
                'text'    => $this->_getText(),
            ]
        );
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $css = [];
        $view = App::getInstance()->getView();

        if ($this->get('hasEditor') === false) {
            $css = array_merge(
                $css,
                $view->generateCss(
                    $this->get('designTextModel'),
                    sprintf('.block-%s', $this->getBlockId())
                )
            );
        }

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get('designBlockModel'),
                sprintf('.block-%s', $this->getBlockId())
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
     * Gets text
     *
     * @return string
     */
    private function _getText()
    {
        $text = TextInstanceModel::model()
            ->getByTextId($this->getId())
            ->get('text');

        if ($this->get('hasEditor') === true) {
            return $text;
        }

        return nl2br(strip_tags($text));
    }

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
     * Runs after changing
     *
     * @return void
     */
    protected function afterChange()
    {
        parent::afterChange();

        App::getInstance()->getMemcached()->delete(
            $this->getHtmlMemcachedKey()
        );
    }
}
