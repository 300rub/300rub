<?php

namespace testS\models;

use testS\application\App;
use testS\components\exceptions\CommonException;
use testS\components\exceptions\ModelException;
use testS\components\View;

/**
 * Abstract class for working with content models
 *
 * @package testS\models
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
     * @var int
     */
    private $_blockId = 0;

    /**
     * Content ID === ID
     *
     * @var int
     */
    private $_contentId = 0;

    /**
     * URI
     *
     * @var string
     */
    private $_uri = "";

    /**
     * HTML
     *
     * @var string
     */
    protected $html = "";

    /**
     * CSS
     *
     * @var array
     */
    protected $css = [];

    /**
     * JS
     *
     * @var array
     */
    protected $js = [];

    /**
     * Gets HTML memcached key
     *
     * @param int    $id
     * @param string $uri
     * @param string $parameter
     *
     * @return string
     */
    abstract public function getHtmlMemcachedKey($id, $uri = "", $parameter = "");

    /**
     * Gets CSS memcached key
     *
     * @param int    $id
     * @param string $uri
     *
     * @return string
     */
    abstract public function getCssMemcachedKey($id, $uri = "");

    /**
     * Gets JS memcached key
     *
     * @param int    $id
     * @param string $uri
     *
     * @return string
     */
    abstract public function getJsMemcachedKey($id, $uri = "");

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

        $model = $this->byId($this->getContentId())->withRelations()->find();
        if (!$model instanceof AbstractContentModel) {
            throw new ModelException(
                "Unable to find model: {class} with relations by ID: {id}",
                [
                    "class" => get_class($this),
                    "id"    => $this->getContentId()
                ]
            );
        }

        $model
            ->setUri($this->_uri)
            ->setBlockId($this->_blockId);

        return $model;
    }

    /**
     * Sets block ID
     *
     * @param int $blockId
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
     * @param int $contentId
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
     * @param string $uri
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
        return $this->css;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Generates content
     */
    public function generateContent()
    {
        $memcached = App::getInstance()->getMemcached();
        $contentId = $this->getContentId();

        $cssMemcachedKey = $this->getCssMemcachedKey($contentId);
        $jsMemcachedKey = $this->getJsMemcachedKey($contentId);

        $cssMemcachedValue = $memcached->get($cssMemcachedKey);
        $jsMemcachedValue = $memcached->get($jsMemcachedKey);

        $this->html = $this->generateHtml();

        if ($cssMemcachedValue !== false) {
            $this->css = $cssMemcachedValue;
        } else {
            $css = $this->getContentModel()->generateCss();
            $memcached->set($cssMemcachedKey, $css);
            $this->css = $css;
        }

        if ($jsMemcachedValue !== false) {
            $this->js = $jsMemcachedValue;
        } else {
            $js = $this->getContentModel()->generateJs();
            $memcached->set($jsMemcachedKey, $js);
            $this->js = $js;
        }
    }
}