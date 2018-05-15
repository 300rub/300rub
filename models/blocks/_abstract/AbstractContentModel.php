<?php

namespace ss\models\blocks\_abstract;

use ss\application\App;
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
     * Is fully cached
     *
     * @var bool
     */
    protected $isFullyCached = false;

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
     * Gets HTML memcached key
     *
     * @return string
     */
    private function _getHtmlMemcachedKey() {
        return sprintf(
            '%s_%s_html',
            $this->getTableName(),
            $this->getId()
        );
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    private function _getCssMemcachedKey()
    {
        return sprintf(
            '%s_%s_css',
            $this->getTableName(),
            $this->getId()
        );
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    private function _getJsMemcachedKey()
    {
        return sprintf(
            '%s_%s_js',
            $this->getTableName(),
            $this->getId()
        );
    }

    /**
     * Gets HTML Memcached
     *
     * @param string $key Key
     *
     * @return mixed
     */
    public function getHtmlMemcached($key)
    {
        return App::getInstance()->getMemcached()->get($key);
    }

    /**
     * Sets HTML Memcached
     *
     * @param string $key  Key
     * @param string $html HTML
     *
     * @return AbstractContentModel
     */
    public function setHtmlMemcached($key, $html)
    {
        App::getInstance()->getMemcached()->set($key, $html);
        return $this;
    }

    /**
     * Deletes HTML Memcached
     *
     * @param string $key  Key
     *
     * @return AbstractContentModel
     */
    public function deleteHtmlMemcached($key)
    {
        App::getInstance()->getMemcached()->delete($key);
        return $this;
    }

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
        if ($this->isFullyCached === false) {
            $this->html = $this->_getContentModel()->generateHtml();
            return $this;
        }

        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->_getHtmlMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            $this->html = $memcachedValue;
            return $this;
        }

        $html = $this->_getContentModel()->generateHtml();
        $memcached->set($memcachedKey, $html);
        $this->html = $html;

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
        $memcachedKey = $this->_getCssMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            $this->cssList = $memcachedValue;
            return $this;
        }

        $css = $this->_getContentModel()->generateCss();
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
        $memcachedKey = $this->_getJsMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            $this->jsList = $memcachedValue;
            return $this;
        }

        $jsList = $this->_getContentModel()->generateJs();
        $memcached->set($memcachedKey, $jsList);
        $this->jsList = $jsList;

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

        $this->deleteCache();
    }

    /**
     * Delete cache
     *
     * @return void
     */
    public function deleteCache()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcached
            ->delete($this->_getCssMemcachedKey())
            ->delete($this->_getJsMemcachedKey());

        if ($this->isFullyCached === true) {
            $memcached->delete($this->_getHtmlMemcachedKey());
        }
    }
}
