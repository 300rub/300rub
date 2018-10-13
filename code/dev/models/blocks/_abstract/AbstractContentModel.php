<?php

namespace ss\models\blocks\_abstract;

use ss\application\exceptions\ModelException;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract class for working with content models
 */
abstract class AbstractContentModel extends AbstractModel
{

    /**
     * Content model
     *
     * @var AbstractContentModel
     */
    private $_contentModel = null;

    /**
     * Block ID
     *
     * @var integer
     */
    private $_blockId = 0;

    /**
     * URI
     *
     * @var string
     */
    private $_uri = '';

    /**
     * HTML
     *
     * @var string
     */
    protected $html = '';

    /**
     * CSS list
     *
     * @var array
     */
    protected $cssList = [];

    /**
     * JS list
     *
     * @var array
     */
    protected $jsList = [];

    /**
     * Generates HTML
     *
     * @return string
     */
    abstract public function generateHtml();

    /**
     * Generates CSS
     *
     * @return string
     */
    abstract public function generateCss();

    /**
     * Generates Js
     *
     * @return string
     */
    abstract public function generateJs();

    /**
     * Gets content model
     *
     * @return AbstractContentModel|mixed
     *
     * @throws ModelException
     */
    private function _getContentModel()
    {
        if ($this->_contentModel instanceof AbstractContentModel) {
            return $this->_contentModel;
        }

        $model = $this->_getModelForContent();
        if ($model instanceof AbstractContentModel === false) {
            throw new ModelException(
                'Unable to find model: {class} with relations by ID: {id}',
                [
                    'class' => get_class($this),
                    'id'    => $this->getId()
                ]
            );
        }

        $model->setBlockId($this->_blockId);

        return $model;
    }

    /**
     * Gets content model
     *
     * @return null|AbstractModel|AbstractContentModel
     */
    private function _getModelForContent()
    {
        return $this->byId($this->getId())->find();
    }

    /**
     * Sets block ID
     *
     * @param int $blockId Block ID
     *
     * @return AbstractContentModel
     */
    public function setBlockId($blockId)
    {
        $this->_blockId = $blockId;
        return $this;
    }

    /**
     * Gets block ID
     *
     * @return int
     */
    protected function getBlockId()
    {
        return $this->_blockId;
    }

    /**
     * Sets URI
     *
     * @param string $uri URI
     *
     * @return AbstractContentModel
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }

    /**
     * Gets HTML
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    public function getCss()
    {
        return $this->cssList;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    public function getJs()
    {
        return $this->jsList;
    }

    /**
     * Generates content
     *
     * @return void
     */
    public function generateContent()
    {
        $this
            ->_setHtml()
            ->_setCssList()
            ->_setJsList();
    }

    /**
     * Sets HTML
     *
     * @return AbstractContentModel
     */
    private function _setHtml()
    {
        $this->html = $this->_getContentModel()->generateHtml();
        return $this;
    }

    /**
     * Sets CSS list
     *
     * @return AbstractContentModel
     */
    private function _setCssList()
    {
        $this->cssList = $this->_getContentModel()->generateCss();;
        return $this;
    }

    /**
     * Sets JS list
     *
     * @return AbstractContentModel
     */
    private function _setJsList()
    {
        $this->jsList = $this->_getContentModel()->generateJs();
        return $this;
    }
}
