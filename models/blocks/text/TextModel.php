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
     * Gets HTML memcached key
     *
     * @return string
     */
    public function getHtmlMemcachedKey()
    {
        return sprintf('text_%s_html', $this->getId());
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    public function getCssMemcachedKey()
    {
        return sprintf('text_%s_css', $this->getId());
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    public function getJsMemcachedKey()
    {
        return sprintf('text_%s_js', $this->getId());
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
        $htmlMemcachedKey = $this->getHtmlMemcachedKey();
        $htmlMemcachedValue = $memcached->get($htmlMemcachedKey);

        if ($htmlMemcachedValue !== false) {
            return $htmlMemcachedValue;
        }

        $textInstanceModel = $this->getTextInstanceModel();

        $html = App::getInstance()->getView()->get(
            'content/text/text',
            [
                'blockId' => $this->getBlockId(),
                'text'    => $textInstanceModel->get('text'),
            ]
        );

        $memcached->set($htmlMemcachedKey, $html);

        return $html;
    }

    /**
     * Gets TextInstanceModel
     *
     * @return TextInstanceModel
     *
     * @throws ModelException
     */
    public function getTextInstanceModel()
    {
        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel = $textInstanceModel
            ->byTextId($this->getId())
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
     * Gets TextModel
     *
     * @return TextModel
     */
    public static function model()
    {
        return new self;
    }
}
