<?php

namespace ss\application\instances\_abstract;

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

        $this->getMemcached()->setPrefix(
            sprintf(
                'site%s_',
                $siteModel->getId()
            )
        );

        $siteModel->setMainHost();

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

        $this->getLanguage()->setActiveId($siteModel->get('language'));

        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $siteModel->setUri($requestUri);

        $this->_site = $siteModel;

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
        $siteModel = new SiteModel;

        $memcachedKey = 'site_' . str_replace('.', '_', $hostname);
        $memcachedResult = $this->getMemcached()->get($memcachedKey, true);
        if ($memcachedResult !== false) {
            $siteModel->set($memcachedResult);
            return $siteModel;
        }

        $baseHost = $this->getConfig()->getValue(['host']);
        $baseHostLength = strlen($baseHost);
        $hostnameLength = strlen($hostname);

        $this->getDb()->setActivePdoKey(Db::CONFIG_DB_NAME_SYSTEM);

        if ($hostnameLength > ($baseHostLength + 1)) {
            $hostnameEnd = substr($hostname, (-1 * $baseHostLength));
            if ($hostnameEnd === $baseHost) {
                $name = substr($hostname, 0, (-1 * ($baseHostLength + 1)));
                return $siteModel->byName($name)->find();
            }
        }

        $siteModel = $siteModel->byDomain($hostname)->find();
        if ($siteModel === null) {
            throw new NotFoundException(
                'Unable to find site with host: {host}',
                [
                    'host' => $hostname
                ]
            );
        }

        $this->getMemcached()->set(
            $memcachedKey,
            $siteModel->get(),
            null,
            true
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
