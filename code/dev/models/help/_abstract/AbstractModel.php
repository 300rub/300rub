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
     * Sets name
     *
     * @return AbstractModel
     */
    protected function setName()
    {
        $this->_name = $this->getLanguageModel()->get('name');
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
     * Sets text
     *
     * @return AbstractModel
     */
    protected function setText()
    {
        $this->_text = $this->getLanguageModel()->get('text');
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
     * Sets title
     *
     * @return AbstractModel
     */
    protected function setTitle()
    {
        $this->_title = $this->getLanguageModel()->get('title');
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
     * Sets keywords
     *
     * @return AbstractModel
     */
    protected function setKeywords()
    {
        $this->_keywords = $this->getLanguageModel()->get('keywords');
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
     * Sets description
     *
     * @return AbstractModel
     */
    protected function setDescription()
    {
        $this->_description = $this->getLanguageModel()->get('description');
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
     * Sets breadcrumbs
     *
     * @return AbstractModel
     */
    protected function setBreadcrumbs()
    {
        $this->_breadcrumbs = $this->generateBreadcrumbs(
            $this->getAlias(),
            $this->getName()
        );
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
     * Sets content
     *
     * @return AbstractModel
     */
    public function setContent()
    {
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
