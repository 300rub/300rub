<?php

namespace ss\application\components\db\sites;

use ss\application\App;
use ss\application\components\common\Language;
use ss\application\components\db\Db;
use ss\application\exceptions\DbException;
use ss\application\exceptions\SiteCreateException;
use ss\models\system\SiteModel;

/**
 * Creates DB
 */
class Create
{

    /**
     * Max attempts
     */
    const MAX_ATTEMPTS = 15;

    /**
     * Site Model
     *
     * @var SiteModel
     */
    private $_siteModel = null;

    /**
     * DB host
     *
     * @var string
     */
    private $_dbHost = '';

    /**
     * DB user
     *
     * @var string
     */
    private $_dbUser = '';

    /**
     * DB password
     *
     * @var string
     */
    private $_dbPassword = '';

    /**
     * DB name
     *
     * @var string
     */
    private $_dbName = '';

    /**
     * Creates new DB
     *
     * @throws \Exception
     */
    public function create()
    {
        try {
            $this
                ->_checkConnection()
                ->_createNewSiteRecord()
                ->_generateDbCredentials()
                ->_createNewDb()
                ->_updateSiteModel()
                ->_importSourceDump();

            App::getInstance()->getDb()->commitAll();
        } catch (\Exception $e) {
            throw new SiteCreateException($e->getMessage());
        }
    }

    /**
     * Gets site model
     *
     * @return SiteModel
     */
    public function getSiteModel()
    {
        return $this->_siteModel;
    }

    /**
     * Checks connection
     *
     * @param int $attempt Attempt
     *
     * @return Create
     *
     * @throws DbException
     */
    private function _checkConnection($attempt = 1)
    {
        $config = App::getInstance()->getConfig();
        $dbHost = App::getInstance()->getDb()->getRandomDbHost();

        if ($attempt > self::MAX_ATTEMPTS) {
            throw new DbException(
                'Unable to connect to BD host: {host}',
                [
                    'host' => $dbHost,
                ]
            );
        }

        try {
            $conn = new \PDO(
                sprintf(
                    'mysql:host=%s;',
                    $dbHost
                ),
                $config->getValue(['db', 'root', $dbHost, 'user']),
                $config->getValue(['db', 'root', $dbHost, 'password'])
            );

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            sleep(1);
            $this->_checkConnection($attempt + 1);
        }

        return $this;
    }

    /**
     * Creates new site record
     *
     * @return Create
     */
    private function _createNewSiteRecord()
    {
        $name = substr(
            md5(
                uniqid() . rand(1, 10)
            ),
            0,
            10
        );

        $email = sprintf(
            '%s@%s',
            substr(
                md5(
                    uniqid() . rand(1, 10)
                ),
                0,
                5
            ),
            App::getInstance()->getConfig()->getValue(['host'])
        );

        App::getInstance()->getDb()->setActivePdoKey(
            Db::CONFIG_DB_NAME_SYSTEM
        );

        $this->_siteModel = new SiteModel();
        $this->_siteModel->set(
            [
                'name'       => $name,
                'language'   => Language::LANGUAGE_RU_ID,
                'email'      => $email,
                'dbHost'     => 'tmp',
                'dbUser'     => 'tmp',
                'dbPassword' => 'tmp',
                'dbName'     => 'tmp',
                'isDisabled' => true,
            ]
        );
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Generates DB credentials
     *
     * @return Create
     */
    private function _generateDbCredentials()
    {
        $formattedSiteId = sprintf(
            '%07d',
            $this->_siteModel->getId()
        );

        $this->_dbHost = App::getInstance()->getDb()->getRandomDbHost();
        $this->_dbUser = sprintf(
            'u%s_%s',
            $formattedSiteId,
            uniqid()
        );
        $this->_dbPassword = sprintf(
            'p%s_%s',
            $formattedSiteId,
            uniqid()
        );
        $this->_dbName = sprintf(
            'site%s',
            $formattedSiteId
        );

        return $this;
    }

    /**
     * Creates new DBs
     *
     * @return Create
     */
    private function _createNewDb()
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->createDb(
                $this->_dbHost,
                $this->_dbUser,
                $this->_dbPassword,
                $dbObject->getReadDbName(
                    $this->_dbName
                )
            )
            ->createDb(
                $this->_dbHost,
                $this->_dbUser,
                $this->_dbPassword,
                $dbObject->getWriteDbName(
                    $this->_dbName
                )
            );

        return $this;
    }

    /**
     * Updates site model
     *
     * @return Create
     */
    private function _updateSiteModel()
    {
        App::getInstance()->getDb()->setActivePdoKey(
            Db::CONFIG_DB_NAME_SYSTEM
        );

        $this->_siteModel->set(
            [
                'dbHost'     => $this->_dbHost,
                'dbUser'     => $this->_dbUser,
                'dbPassword' => $this->_dbPassword,
                'dbName'     => $this->_dbName,
            ]
        );
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Imports source dump
     *
     * @return Create
     */
    private function _importSourceDump()
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->importDb(
                $this->_dbHost,
                $dbObject->getWriteDbName(
                    $this->_dbName
                ),
                Db::SOURCE_PATH
            )
            ->importDb(
                $this->_dbHost,
                $dbObject->getReadDbName(
                    $this->_dbName
                ),
                Db::SOURCE_PATH
            );

        return $this;
    }
}
