<?php

namespace ss\application\instances\_abstract;

use ss\application\App;
use ss\application\components\common\ErrorHandler;
use ss\application\components\db\Db;
use ss\application\exceptions\NotFoundException;
use ss\models\_abstract\AbstractModel;
use ss\models\system\SiteModel;

/**
 * Abstract class for work with application
 */
abstract class AbstractApplication extends AbstractComponents
{

    /**
     * Site
     *
     * @var SiteModel
     */
    private $_site = null;

    /**
     * Runs application
     *
     * @return void
     */
    abstract public function run();

    /**
     * Constructor
     *
     * @param array $config Settings from config
     */
    public function __construct($config)
    {
        session_start();

        $this
            ->setConfig($config)
            ->_activateVendorAutoload()
            ->_setErrorHandler();
    }

    /**
     * Sets Error Handler
     *
     * @return AbstractApplication
     */
    private function _setErrorHandler()
    {
        $errorHandler = new ErrorHandler();
        $errorHandler
            ->setErrorReporting()
            ->setExceptionHandler();

        return $this;
    }

    /**
     * Activates vendor autoload
     *
     * @return AbstractApplication
     */
    private function _activateVendorAutoload()
    {
        include_once CODE_ROOT . '/vendor/autoload.php';

        return $this;
    }

    /**
     * Sets site
     *
     * @param string $hostname Site hostname
     *
     * @return AbstractApplication
     *
     * @throws NotFoundException
     */
    protected function setSite($hostname)
    {
        $siteModel = $this->_getSiteModel($hostname);

        $this->getDb()
            ->addPdo(
                $siteModel->get('dbHost'),
                $siteModel->get('dbUser'),
                $siteModel->get('dbPassword'),
                $siteModel->getReadDbName()
            )
            ->addPdo(
                $siteModel->get('dbHost'),
                $siteModel->get('dbUser'),
                $siteModel->get('dbPassword'),
                $siteModel->getWriteDbName()
            )
            ->setActivePdoKey(
                $siteModel->getReadDbName()
            );

        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $siteModel->setUri($requestUri);

        $this->_site = $siteModel;

        return $this;
    }

    /**
     * Sets active language
     *
     * @param bool $skipAlias Flag to skip alias
     *
     * @return AbstractApplication
     */
    protected function setActiveLanguage($skipAlias = null)
    {
        if ($skipAlias !== true) {
            $languageAlias = $this->_site->getUri(0);
            if ($languageAlias !== null) {
                $this->getLanguage()->setIdByAlias($languageAlias);
                return $this;
            }
        }

        $this->getLanguage()->setActiveId($this->_site->get('language'));
        return $this;
    }

    /**
     * Gets site memcached key
     *
     * @param string $hostname Hostname
     *
     * @return string
     */
    private function _getSiteMemcachedKey($hostname)
    {
        return md5($hostname);
    }

    /**
     * Deletes site memcached
     *
     * @param string $hostname Hostname
     *
     * @return AbstractApplication
     */
    public function deleteSiteMemcached($hostname)
    {
        App::getInstance()->getMemcached()->delete(
            $this->_getSiteMemcachedKey($hostname)
        );

        return $this;
    }

    /**
     * Gets SiteModel by hostname
     *
     * @param string $hostname Hostname
     *
     * @return SiteModel|AbstractModel
     *
     * @throws NotFoundException
     */
    private function _getSiteModel($hostname)
    {
        $memcached = $this->getMemcached();
        $memcachedResult = $memcached->get(
            $this->_getSiteMemcachedKey($hostname)
        );
        if ($memcachedResult !== false) {
            return SiteModel::model()->set($memcachedResult);
        }

        $baseHost = $this->getConfig()->getValue(['host']);
        $baseHostLength = strlen($baseHost);
        $hostnameLength = strlen($hostname);

        $this->getDb()->setActivePdoKey(Db::CONFIG_DB_NAME_SYSTEM);
        $siteModel = null;

        if ($hostnameLength > ($baseHostLength + 1)) {
            $hostnameEnd = substr($hostname, (-1 * $baseHostLength));
            if ($hostnameEnd === $baseHost) {
                $name = substr($hostname, 0, (-1 * ($baseHostLength + 1)));
                $siteModel = SiteModel::model()->byName($name)->find();
            }
        }

        if ($siteModel === null) {
            $siteModel = SiteModel::model()->byDomain($hostname)->find();
            if ($siteModel === null) {
                throw new NotFoundException(
                    'Unable to find site with host: {host}',
                    [
                        'host' => $hostname
                    ]
                );
            }
        }

        $memcached->set(
            $this->_getSiteMemcachedKey($hostname),
            $siteModel->get()
        );

        return $siteModel;
    }

    /**
     * Gets site
     *
     * @return SiteModel
     */
    public function getSite()
    {
        return $this->_site;
    }
}
