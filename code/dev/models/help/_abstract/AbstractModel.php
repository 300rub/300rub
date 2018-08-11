<?php

namespace ss\models\help\_abstract;

use ss\application\App;
use ss\models\_abstract\AbstractModel as BaseModel;

/**
 * Abstract model to keep html information
 */
abstract class AbstractModel extends BaseModel
{

    /**
     * Alias
     *
     * @var string
     */
    private $_alias = '';

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
     * Sets content
     *
     * @return AbstractModel
     */
    abstract public function setContent();

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
    protected function getAlias()
    {
        return $this->_alias;
    }

    /**
     * Sets title
     *
     * @param string $title Title
     *
     * @return AbstractModel
     */
    protected function setTitle($title)
    {
        $this->_title = $title;
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
     * @param string $keywords Keywords
     *
     * @return AbstractModel
     */
    protected function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
        return $this;
    }

    /**
     * Gets keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->_title;
    }

    /**
     * Sets description
     *
     * @param string $description Description
     *
     * @return AbstractModel
     */
    protected function setDescription($description)
    {
        $this->_description = $description;
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
}
