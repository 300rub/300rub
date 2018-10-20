<?php

namespace ss\models\blocks\text\_content;

use ss\application\App;
use ss\application\exceptions\ModelException;
use ss\models\blocks\text\_base\AbstractTextModel;
use ss\models\blocks\text\DesignTextModel;
use ss\models\blocks\text\TextInstanceModel;

/**
 * Abstract model for working text content
 */
abstract class AbstractContentTextModel extends AbstractTextModel
{

    /**
     * Tag list
     *
     * @var array
     */
    private $_tagList = [
        self::TYPE_DIV => 'div',
        self::TYPE_H1  => 'h1',
        self::TYPE_H2  => 'h2',
        self::TYPE_H3  => 'h3',
    ];

    /**
     * Gets tag
     *
     * @return string
     */
    private function _getTag()
    {
        $type = $this->get('type');

        if (array_key_exists($type, $this->_tagList) === true) {
            return $this->_tagList[$type];
        }

        return $this->_tagList[self::TYPE_DIV];
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
                'tag'     => $this->_getTag(),
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

        $designTextModel = new DesignTextModel();
        if ($this->get('hasEditor') === false) {
            $designTextModel = $this->get('designTextModel');
        }

        $css = array_merge(
            $css,
            $view->generateCss(
                $designTextModel,
                sprintf('.block-%s', $this->getBlockId())
            )
        );

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

        $text = htmlspecialchars($text);

        if ($this->get('type') === self::TYPE_DIV) {
            return nl2br($text);
        }

        return $text;
    }
}
