<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\common\Language;
use ss\application\components\db\Db;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\models\system\SiteModel;

/**
 * Creates source DB
 */
class CreateSourceDbCommand extends AbstractDbCommand
{

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
     * Runs the command
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->checkConnection();

        try {
            $this
                ->_createNewSiteRecord()
                ->_generateDbCredentials()
                ->_createNewDb()
                ->_updateSiteModel()
                ->_importSourceDump();

            App::getInstance()->getDb()->commitAll();
        } catch (\Exception $e) {
            App::getInstance()->getDb()->rollBackAll();

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
            'isSource'   => true,
            ]
        );
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

        return $this;
    }

    /**
     * Creates new DBs
     *
     * @return CreateSourceDbCommand
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
     * @return CreateSourceDbCommand
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
     * @return CreateSourceDbCommand
     */
    private function _importSourceDump()
    {
        $dbObject = App::getInstance()->getDb();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $this->_dbPassword,
                $this->_dbUser,
                $this->_dbHost,
                $dbObject->getReadDbName(
                    $this->_dbName
                ),
                Db::SOURCE_PATH
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $this->_dbPassword,
                $this->_dbUser,
                $this->_dbHost,
                $dbObject->getWriteDbName(
                    $this->_dbName
                ),
                Db::SOURCE_PATH
            )
        );

        return $this;
    }
}
