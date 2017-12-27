<?php

namespace testS\models\blocks\_abstract;

use testS\application\App;
use testS\application\exceptions\ModelException;
use testS\models\_abstract\AbstractModel;

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
     * Content ID === ID
     *
     * @var integer
     */
    private $_contentId = 0;

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
     * Gets HTML memcached key
     *
     * @return string
     */
    abstract public function getHtmlMemcachedKey();

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    abstract public function getCssMemcachedKey();

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    abstract public function getJsMemcachedKey();

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
     * @return AbstractContentModel
     *
     * @throws ModelException
     */
    protected function getContentModel()
    {
        if ($this->_contentModel instanceof AbstractContentModel) {
            return $this->_contentModel;
        }

        $model = $this->_getContentModel();
        if ($model instanceof AbstractContentModel === false) {
            throw new ModelException(
                'Unable to find model: {class} with relations by ID: {id}',
                [
                    'class' => get_class($this),
                    'id'    => $this->getContentId()
                ]
            );
        }

        $model
            ->setUri($this->_uri)
            ->setBlockId($this->_blockId);

        return $model;
    }

    /**
     * Gets content model
     *
     * @return null|AbstractModel|AbstractContentModel
     */
    private function _getContentModel()
    {
        return $this->byId($this->getContentId())->withRelations()->find();
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
     * Sets content ID
     *
     * @param int $contentId Content ID
     *
     * @return AbstractContentModel
     */
    public function setContentId($contentId)
    {
        $this->_contentId = $contentId;
        return $this;
    }

    /**
     * Gets content ID
     *
     * @return int
     */
    protected function getContentId()
    {
        return $this->_contentId;
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
     * Gets URI
     *
     * @return string
     */
    protected function getUri()
    {
        return $this->_uri;
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
        $this->html = $this->generateHtml();
        return $this;
    }

    /**
     * Sets CSS list
     *
     * @return AbstractContentModel
     */
    private function _setCssList()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getCssMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            $this->cssList = $memcachedValue;
            return $this;
        }

        $css = $this->getContentModel()->generateCss();
        $memcached->set($memcachedKey, $css);
        $this->cssList = $css;

        return $this;
    }

    /**
     * Sets JS list
     *
     * @return AbstractContentModel
     */
    private function _setJsList()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getJsMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            $this->jsList = $memcachedValue;
            return $this;
        }

        $jsList = $this->getContentModel()->generateJs();
        $memcached->set($memcachedKey, $jsList);
        $this->jsList = $jsList;

        return $this;
    }
}
