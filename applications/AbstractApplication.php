<?php

/**
 * PHP version 7
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications;

use testS\components\Db;
use testS\components\ErrorHandler;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Memcached;
use testS\models\SiteModel;

/**
 * Abstract class for work with application
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
abstract class AbstractApplication
{

    /**
     * Settings from config
     *
     * @var array
     */
    private $config = null;

    /**
     * Memcached
     *
     * @var Memcached
     */
    private $memcached = null;

    /**
     * Site
     *
     * @var SiteModel
     */
    protected $site = null;

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
        $this
            ->setErrorHandler()
            ->setConfig($config)
            ->activateVendorAutoload()
            ->setMemcached();
    }

    /**
     * Sets Error Handler
     *
     * @return AbstractApplication
     */
    private function setErrorHandler()
    {
        new ErrorHandler();

        return $this;
    }

    /**
     * Parses config settings
     *
     * @param array $config Config settings
     *
     * @return AbstractApplication
     */
    private function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Gets config
     *
     * @param array $path Path for config item
     *
     * @return mixed
     */
    public function getConfig(array $path = [])
    {
        $value = $this->config;

        if (count($path) === 0) {
            return $value;
        }

        foreach ($path as $item) {
            if (!is_array($value)
                || !array_key_exists($item, $value)
            ) {
                return null;
            }

            $value = $value[$item];
        }

        return $value;
    }

    /**
     * Activates vendor autoload
     *
     * @return AbstractApplication
     */
    private function activateVendorAutoload()
    {
        include_once __DIR__ . "/../vendor/autoload.php";

        return $this;
    }

    /**
     * Sets Memcached
     *
     * @return AbstractApplication
     */
    private function setMemcached()
    {
        $this->memcached = new Memcached(
            $this->getConfig(["memcached", "host"]),
            $this->getConfig(["memcached", "port"])
        );

        return $this;
    }

    /**
     * Gets Memcached
     *
     * @return Memcached
     */
    public function getMemcached()
    {
        return $this->memcached;
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
    protected function setSite($hostname = null)
    {
        if (APP_ENV === ENV_DEV || $hostname === null) {
            $hostname = DEV_HOST;
        }

        $memcachedKey = "site_" . $hostname;
        $siteModel = $this->getMemcached()->get($memcachedKey);
        if (!$siteModel instanceof SiteModel) {
            Db::setSystemPdo();

            $siteModel = (new SiteModel())->byHost($hostname)->find();
            if ($siteModel === null) {
                throw new NotFoundException(
                    "Unable to find site with host: {host}",
                    [
                    "host" => $hostname
                    ]
                );
            }

            $this->getMemcached()->set($memcachedKey, $siteModel);
        }

        Db::setPdo(
            $siteModel->get("dbHost"),
            $siteModel->get("dbUser"),
            $siteModel->get("dbPassword"),
            $siteModel->get("dbName")
        );

        Language::setActiveId($siteModel->get("language"));

        $this->site = $siteModel;

        return $this;
    }

    /**
     * Gets site
     *
     * @return SiteModel
     */
    public function getSite()
    {
        return $this->site;
    }
}