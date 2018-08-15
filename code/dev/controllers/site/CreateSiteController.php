<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\Db;
use ss\commands\db\MigrateCommand;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\system\SiteModel;

/**
 * CreateSiteController to get create a new site
 */
class CreateSiteController extends AbstractController
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
     * Gets site page
     *
     * @return string
     */
    public function run()
    {
        $this->checkData(
            [
                'address'         => [self::TYPE_STRING, self::NOT_EMPTY],
                'name'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'email'           => [self::TYPE_STRING, self::NOT_EMPTY],
                'user'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'password'        => [self::TYPE_STRING, self::NOT_EMPTY],
                'passwordConfirm' => [self::TYPE_STRING, self::NOT_EMPTY],
                'language'        => [self::NOT_EMPTY],
            ]
        );

        if ($this->get('password') !== $this->get('passwordConfirm')) {
            return [
                'errors' => [
                    'passwordConfirm' => App::getInstance()
                        ->getLanguage()
                        ->getMessage('user', 'passwordsMatch')
                ]
            ];
        }

        $this->_systemDb = new Db();
        $this->_systemDb->setSystemPdo();
        $this->_systemDb->startTransaction();
        try {
            $this->_createNewSite();

            $errors = $this->_siteModel->getErrors();
            if (count($errors) > 0) {
                return [
                    'errors' => $errors
                ];
            }

            $this
                ->_generateDbCredentials()
                ->_createNewDb()
                ->_updateSiteModel()
                ->_applyMigrations();

            $this->_systemDb->commitTransaction();
        } catch (\Exception $e) {
            $this->_systemDb->rollbackTransaction();

            return [
                'result' => $e->getMessage(),
            ];
        }

        return [
            'result' => true,
        ];
    }

    /**
     * Applies migrations for new DB
     *
     * @return CreateSiteController
     */
    private function _applyMigrations()
    {
        $migrateCommand = new MigrateCommand();
        $migrateCommand->setupNewDb(
            $this->_dbHost,
            $this->_dbUser,
            $this->_dbPassword,
            $this->_dbName
        );

        return $this;
    }

    /**
     * Creates new site
     *
     * @return CreateSiteController
     */
    private function _createNewSite()
    {
        $this->_siteModel = new SiteModel();
        $this->_siteModel->setDb($this->_systemDb);
        $this->_siteModel->set([
            'name'       => $this->get('name'),
            'language'   => $this->get('language'),
            'email'      => $this->get('email'),
            'dbHost'     => 'tmp',
            'dbUser'     => 'tmp',
            'dbPassword' => 'tmp',
            'dbName'     => 'tmp',
        ]);
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Updates site model
     *
     * @return CreateSiteController
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
     * Generates DB credentials
     *
     * @return CreateSiteController
     */
    private function _generateDbCredentials()
    {
        $formattedSiteId = sprintf(
            '%07d',
            $this->_siteModel->getId()
        );

        $this->_dbHost = $this->_getRandomDbHost();
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
     * @return CreateSiteController
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
     * Gets random DB host
     *
     * @return string
     */
    private function _getRandomDbHost()
    {
        $hosts = array_keys(
            App::getInstance()->getConfig()->getValue(['db', 'root'])
        );
        shuffle($hosts);

        return $hosts[0];
    }
}
