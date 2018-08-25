<?php

namespace ss\models\system;

use ss\application\App;

use ss\application\components\db\Table;
use ss\models\_abstract\AbstractModel;
use ss\models\sections\SectionModel;
use ss\models\system\_base\AbstractSiteModel;

/**
 * Model for working with table "sites"
 */
class SiteModel extends AbstractSiteModel
{

    /**
     * Main host
     *
     * @var string
     */
    private $_mainHost = '';

    /**
     * URI
     *
     * @var string
     */
    private $_uri = '';

    /**
     * Parameters
     *
     * @var array
     */
    private $_parameters = [];

    /**
     * Active section
     *
     * @var SectionModel
     */
    private $_activeSection = null;

    /**
     * Sections collection
     *
     * @var array
     */
    private $_sections = [];

    /**
     * Adds name condition to SQL request
     *
     * @param string $name Name
     *
     * @return SiteModel
     */
    public function byName($name)
    {
        $this->getTable()
            ->addWhere(
                sprintf(
                    '%s.name = :name',
                    Table::DEFAULT_ALIAS
                )
            )
            ->addParameter('name', $name);

        return $this;
    }

    /**
     * Adds domain condition to SQL request
     *
     * @param string $name Name
     *
     * @return SiteModel
     */
    public function byDomain($name)
    {
        $this->getTable()
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'domains',
                'domains',
                'siteId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addWhere('domains.name = :name')
            ->addParameter('name', $name);

        return $this;
    }

    /**
     * Gets internal host
     *
     * @return string
     */
    public function getInternalHost()
    {
        return sprintf(
            '%s.%s',
            $this->get('name'),
            App::getInstance()->getConfig()->getValue(['host'])
        );
    }

    /**
     * Sets main host
     *
     * @return SiteModel
     */
    public function setMainHost()
    {
        $domains = DomainModel::model()->getModelsBySiteId($this->getId());

        if (count($domains) > 0) {
            foreach ($domains as $domain) {
                if ($domain->get('isMain') === true) {
                    $this->_mainHost = $domain->get('name');
                    return $this;
                }
            }

            foreach ($domains as $domain) {
                $this->_mainHost = $domain->get('name');
                return $this;
            }
        }

        $this->_mainHost = $this->getInternalHost();
        return $this;
    }

    /**
     * Gets main host
     *
     * @return string
     */
    public function getMainHost()
    {
        return $this->_mainHost;
    }

    /**
     * Sets site URI
     *
     * @param string $uri URI
     *
     * @return SiteModel
     */
    public function setUri($uri)
    {
        if (strpos($uri, '?') === false) {
            $this->_uri = trim($uri, '/');
            return $this;
        }

        list($uri, $parameters) = explode('?', $uri);

        parse_str($parameters, $parsedParameters);

        $this->_uri = trim($uri, '/');
        $this->_parameters = $parsedParameters;

        return $this;
    }

    /**
     * Gets site URI
     *
     * @param integer $part 0/1/2/3...
     *
     * @return string|null
     */
    public function getUri($part = null)
    {
        if ($part === null) {
            return $this->_uri;
        }

        if (strlen($this->_uri) === 0) {
            return null;
        }

        if (strpos($this->_uri, '/') === false) {
            if ($part === 0) {
                return $this->_uri;
            }
        }

        $explode = explode('/', $this->_uri);
        if (array_key_exists($part, $explode) === true) {
            return $explode[$part];
        }

        return null;
    }

    /**
     * Gets parameter
     *
     * @param int    $blockId Block ID
     * @param string $name    Parameter name
     *
     * @return mixed
     */
    public function getParameter($blockId, $name = null)
    {
        if ($name === null) {
            if (array_key_exists('block', $this->_parameters) === false
                || (int)$blockId !== (int)$this->_parameters['block']
            ) {
                return null;
            }

            return $this->_parameters;
        }

        if (array_key_exists($name, $this->_parameters) === true
            && array_key_exists('block', $this->_parameters) === true
            && (int)$blockId === (int)$this->_parameters['block']
        ) {
            return $this->_parameters[$name];
        }

        return null;
    }

    /**
     * Sets active section
     *
     * @param SectionModel|AbstractModel $sectionModel Section model
     *
     * @return SiteModel
     */
    public function setActiveSection($sectionModel)
    {
        $this->_activeSection = $sectionModel;
        return $this;
    }

    /**
     * Gets active section
     *
     * @return SectionModel
     */
    public function getActiveSection()
    {
        return $this->_activeSection;
    }

    /**
     * Gets active section URI
     *
     * @return string
     */
    public function getActiveSectionUri()
    {
        return $this->getActiveSection()->getUri();
    }

    /**
     * Gets Section by ID
     *
     * @param int $sectionId Section ID
     *
     * @return SectionModel
     */
    public function getSectionById($sectionId)
    {
        if (array_key_exists($sectionId, $this->_sections) === false) {
            $section = SectionModel::model()
                ->byId($sectionId)
                ->withRelations(['seoModel'])
                ->find();
            if ($section !== null) {
                $this->_sections[$sectionId] = $section;
            }
        }

        return $this->_sections[$sectionId];
    }

    /**
     * Adds source condition to SQL request
     *
     * @return SiteModel
     */
    public function source()
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.isSource = 1',
                Table::DEFAULT_ALIAS
            )
        );

        return $this;
    }

    /**
     * Gets Site model
     *
     * @return SiteModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets read DB name
     *
     * @return string
     */
    public function getReadDbName()
    {
        return App::getInstance()
            ->getDb()
            ->getReadDbName($this->get('dbName'));
    }

    /**
     * Gets write DB name
     *
     * @return string
     */
    public function getWriteDbName()
    {
        return App::getInstance()
            ->getDb()
            ->getWriteDbName($this->get('dbName'));
    }
}
