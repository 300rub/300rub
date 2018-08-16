<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\Language;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\models\system\SiteModel;

/**
 * Creates source DB
 */
class CreateSourceDbCommand extends AbstractDbCommand
{

    /**
     * System DB
     *
     * @var Db
     */
    private $_systemDb = null;

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
     * DB Admin name
     *
     * @var string
     */
    private $_dbNameAdmin = '';

    /**
     * Runs the command
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->checkConnection();

        $this->_systemDb = new Db();
        $this->_systemDb->setSystemPdo();
        $this->_systemDb->startTransaction();
        try {
            $this
                ->_createNewSiteRecord()
                ->_generateDbCredentials()
                ->_createNewDb()
                ->_updateSiteModel()
                ->_importSourceDump();

            $this->_systemDb->commitTransaction();
        } catch (\Exception $e) {
            $this->_systemDb->rollbackTransaction();

            throw $e;
        }
    }

    /**
     * Creates new site record
     *
     * @return CreateSourceDbCommand
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

        $this->_siteModel = new SiteModel();
        $this->_siteModel->setDb($this->_systemDb);
        $this->_siteModel->set([
            'name'       => $name,
            'language'   => Language::LANGUAGE_RU_ID,
            'email'      => $email,
            'dbHost'     => 'tmp',
            'dbUser'     => 'tmp',
            'dbPassword' => 'tmp',
            'dbName'     => 'tmp',
            'isSource'   => true,
        ]);
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Generates DB credentials
     *
     * @return CreateSourceDbCommand
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
        $this->_dbNameAdmin = sprintf(
            'site%sAdmin',
            $formattedSiteId
        );

        return $this;
    }

    /**
     * Creates new DBs
     *
     * @return CreateSourceDbCommand
     */
    private function _createNewDb()
    {
        $newDb = new Db();
        $newDb
            ->createNewDb(
                $this->_dbHost,
                $this->_dbUser,
                $this->_dbPassword,
                $this->_dbName
            )
            ->createNewDb(
                $this->_dbHost,
                $this->_dbUser,
                $this->_dbPassword,
                $this->_dbNameAdmin
            );

        return $this;
    }

    /**
     * Updates site model
     *
     * @return CreateSourceDbCommand
     */
    private function _updateSiteModel()
    {
        $this->_siteModel->set([
            'dbHost'     => $this->_dbHost,
            'dbUser'     => $this->_dbUser,
            'dbPassword' => $this->_dbPassword,
            'dbName'     => $this->_dbName,
        ]);
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Imports source dump
     *
     * @return CreateSourceDbCommand
     */
    private function _importSourceDump()
    {
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/config/db/source.sql',
                $this->_dbPassword,
                $this->_dbUser,
                $this->_dbHost,
                $this->_dbName,
                CODE_ROOT
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/config/db/source.sql',
                $this->_dbPassword,
                $this->_dbUser,
                $this->_dbHost,
                $this->_dbNameAdmin,
                CODE_ROOT
            )
        );

        return $this;
    }
}
