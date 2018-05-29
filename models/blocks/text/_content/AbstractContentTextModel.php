<?php

namespace ss\models\blocks\text\_content;

use ss\application\App;
use ss\application\exceptions\ModelException;
use ss\models\blocks\text\_base\AbstractTextModel;
use ss\models\blocks\text\TextInstanceModel;

/**
 * Abstract model for working text content
 */
abstract class AbstractContentTextModel extends AbstractTextModel
{

    /**
     * Is fully cached
     *
     * @var bool
     */
    protected $isFullyCached = true;

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

        return nl2br(htmlspecialchars($text));
    }
}
