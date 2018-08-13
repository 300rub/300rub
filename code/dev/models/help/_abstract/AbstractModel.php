<?php

namespace ss\models\help\_abstract;

use ss\application\App;
use ss\models\_abstract\AbstractModel as BaseModel;
use ss\models\help\CategoryModel;
use ss\models\help\PageModel;

/**
 * Abstract model to keep html information
 */
abstract class AbstractModel extends BaseModel
{

    /**
     * Type
     */
    const TYPE = 'abstract';

    /**
     * Language model
     *
     * @var BaseModel
     */
    protected $languageModel = null;

    /**
     * Alias
     *
     * @var string
     */
    private $_alias = '';

    /**
     * Base URI
     *
     * @var string
     */
    private $_baseUri = '';

    /**
     * Name
     *
     * @var string
     */
    private $_name = '';

    /**
     * Text
     *
     * @var string
     */
    private $_text = '';

    /**
     * Title
     *
     * @var string
     */
    private $_title = '';

    /**
     * Keywords
     *
     * @var string
     */
    private $_keywords = '';

    /**
     * Description
     *
     * @var string
     */
    private $_description = '';

    /**
     * Breadcrumbs
     *
     * @var array
     */
    private $_breadcrumbs = [];

    /**
     * Gets Language Model
     *
     * @return BaseModel
     */
    abstract protected function getLanguageModel();

    /**
     * Generates breadcrumbs
     *
     * @param string $alias Alias
     * @param string $name  Name
     *
     * @return array
     */
    abstract public function generateBreadcrumbs($alias, $name);

    /**
     * Sets base URI
     *
     * @param string $baseUri Base URI
     *
     * @return AbstractModel|CategoryModel|PageModel
     */
    public function setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
        return $this;
    }

    /**
     * Gets base URI
     *
     * @return string
     */
    protected function getBaseUri()
    {
        return $this->_baseUri;
    }

    /**
     * Sets alias
     *
     * @param string $alias Alias
     *
     * @return AbstractModel
     */
    public function setAlias($alias)
    {
        $this->_alias = $alias;
        return $this;
    }

    /**
     * Gets alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->_alias;
    }

    /**
     * Gets name Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getNameMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_name_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets name
     *
     * @return AbstractModel
     */
    protected function setName()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getNameMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_name = $memcachedResult;
            return $this;
        }

        $this->_name = $this->getLanguageModel()->get('name');
        $memcached->set($memcachedKey, $this->_name);

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Gets text Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getTextMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_text_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets text
     *
     * @return AbstractModel
     */
    protected function setText()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getTextMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_text = $memcachedResult;
            return $this;
        }

        $this->_text = $this->getLanguageModel()->get('text');
        $memcached->set($memcachedKey, $this->_text);

        return $this;
    }

    /**
     * Gets text
     *
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * Gets title Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getTitleMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_title_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets title
     *
     * @return AbstractModel
     */
    protected function setTitle()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getTitleMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_title = $memcachedResult;
            return $this;
        }

        $this->_title = $this->getLanguageModel()->get('title');
        $memcached->set($memcachedKey, $this->_title);

        return $this;
    }

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Gets keywords Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getKeywordsMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_keywords_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets keywords
     *
     * @return AbstractModel
     */
    protected function setKeywords()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getKeywordsMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_keywords = $memcachedResult;
            return $this;
        }

        $this->_keywords = $this->getLanguageModel()->get('keywords');
        $memcached->set($memcachedKey, $this->_keywords);

        return $this;
    }

    /**
     * Gets keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    /**
     * Gets description Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getDescriptionMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_description_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets description
     *
     * @return AbstractModel
     */
    protected function setDescription()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getDescriptionMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_description = $memcachedResult;
            return $this;
        }

        $this->_description = $this->getLanguageModel()->get('description');
        $memcached->set($memcachedKey, $this->_description);

        return $this;
    }

    /**
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Gets breadcrumbs Memcached key
     *
     * @param string $type  Type
     * @param string $alias Alias
     *
     * @return string
     */
    protected function getBreadcrumbsMemcachedKey($type, $alias)
    {
        return sprintf(
            'help_breadcrumbs_%s_%s_%s',
            $type,
            $alias,
            App::getInstance()->getLanguage()->getActiveId()
        );
    }

    /**
     * Sets breadcrumbs
     *
     * @return AbstractModel
     */
    protected function setBreadcrumbs()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->getBreadcrumbsMemcachedKey(
            static::TYPE,
            $this->getAlias()
        );

        $memcachedResult = $memcached->get($memcachedKey);
        if ($memcachedResult !== false) {
            $this->_breadcrumbs = $memcachedResult;
            return $this;
        }

        $this->_breadcrumbs = $this->generateBreadcrumbs(
            $this->getAlias(),
            $this->getName()
        );
        $memcached->set($memcachedKey, $this->_breadcrumbs);

        return $this;
    }

    /**
     * Gets breadcrumbs
     *
     * @return string
     */
    public function getBreadcrumbs()
    {
        return $this->_breadcrumbs;
    }

    /**
     * Sets PDO
     *
     * @return AbstractModel
     */
    protected function setPdo()
    {
        $config = App::getInstance()->getConfig();

        App::getInstance()->getDb()->setPdo(
            $config->getValue(['db', 'help', 'host']),
            $config->getValue(['db', 'help', 'user']),
            $config->getValue(['db', 'help', 'password']),
            $config->getValue(['db', 'help', 'name'])
        );

        return $this;
    }

    /**
     * Sets content
     *
     * @return AbstractModel
     */
    public function setContent()
    {
        $this->setPdo();

        $this
            ->setName()
            ->setText()
            ->setTitle()
            ->setKeywords()
            ->setDescription()
            ->setBreadcrumbs();

        return $this;
    }
}
