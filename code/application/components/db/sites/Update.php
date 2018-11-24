<?php

namespace ss\application\components\db\sites;

use ss\application\App;
use ss\application\components\common\Language;
use ss\application\components\db\Db;
use ss\application\exceptions\NotFoundException;
use ss\application\exceptions\SiteCreateException;
use ss\models\system\SiteModel;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;

/**
 * Updates DB
 */
class Update
{

    /**
     * Site Model
     *
     * @var SiteModel
     */
    private $_siteModel = null;

    /**
     * Name
     *
     * @var string
     */
    private $_name = '';

    /**
     * Language
     *
     * @var int
     */
    private $_language = Language::LANGUAGE_RU_ID;

    /**
     * Email
     *
     * @var string
     */
    private $_email = '';

    /**
     * Token
     *
     * @var string
     */
    private $_token = '';

    /**
     * User
     *
     * @var string
     */
    private $_user = '';

    /**
     * User name
     *
     * @var string
     */
    private $_userName = '';

    /**
     * Password
     *
     * @var string
     */
    private $_password = '';

    /**
     * Sets email
     *
     * @param string $email email
     *
     * @return Update
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * Sets Language
     *
     * @param int $language Language
     *
     * @return Update
     */
    public function setLanguage($language)
    {
        $this->_language = $language;
        return $this;
    }

    /**
     * Sets name
     *
     * @param string $name Name
     *
     * @return Update
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Sets user
     *
     * @param string $user User
     *
     * @return Update
     */
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    /**
     * Sets user name
     *
     * @param string $userName User name
     *
     * @return Update
     */
    public function setUsername($userName)
    {
        $this->_userName = $userName;
        return $this;
    }

    /**
     * Sets password
     *
     * @param string $password Password
     *
     * @return Update
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * Sets site model
     *
     * @param SiteModel $siteModel Site Model
     *
     * @return Update
     */
    public function setSiteModel($siteModel)
    {
        $this->_siteModel = $siteModel;
        return $this;
    }

    /**
     * Updates site
     *
     * @return array
     *
     * @throws \Exception
     */
    public function update()
    {
        try {
            $this->_updateSiteModel();

            $errors = $this->_siteModel->getParsedErrors();
            if (count($errors) > 0) {
                return [
                    'errors' => $errors
                ];
            }

            $this->_createUser();

            App::getInstance()->getDb()->commitAll();

            return [
                'result' => true,
                'url'    => $this->_generateUrl()
            ];
        } catch (\Exception $e) {
            App::getInstance()->getDb()->rollBackAll();
            throw new SiteCreateException($e->getMessage());
        }
    }

    /**
     * Generates URL
     *
     * @return string
     */
    private function _generateUrl()
    {
        $method = 'http';
        $isHttps = App::getInstance()
            ->getSuperGlobalVariable()
            ->isHttps();
        if ($isHttps === true) {
            $method = 'https';
        }

        return sprintf(
            '%s://%s.%s?token=%s',
            $method,
            $this->_siteModel->get('name'),
            App::getInstance()
                ->getConfig()
                ->getValue(['host']),
            $this->_token
        );
    }

    /**
     * Updates site model
     *
     * @return Update
     *
     * @throws NotFoundException
     */
    private function _updateSiteModel()
    {
        App::getInstance()->getDb()
            ->setActivePdoKey(
                Db::CONFIG_DB_NAME_SYSTEM
            )
            ->beginTransaction(
                Db::CONFIG_DB_NAME_SYSTEM
            );

        $this->_siteModel->set(
            [
                'name'       => $this->_name,
                'language'   => $this->_language,
                'email'      => $this->_email,
                'isDisabled' => false,
            ]
        );
        $this->_siteModel->save();

        return $this;
    }

    /**
     * Creates user
     *
     * @return Update
     */
    private function _createUser()
    {
        $dbObject = App::getInstance()->getDb();

        $dbName = $dbObject->getWriteDbName(
            $this->_siteModel->get('dbName')
        );

        $dbObject
            ->addPdo(
                $this->_siteModel->get('dbHost'),
                $this->_siteModel->get('dbUser'),
                $this->_siteModel->get('dbPassword'),
                $dbName
            )
            ->setActivePdoKey($dbName)
            ->beginTransaction($dbName);

        $userModel = new UserModel();
        $userModel->set(
            [
                'login'    => $this->_user,
                'password' => $userModel->getPasswordHash(
                    $this->_password
                ),
                'type'     => UserModel::TYPE_OWNER,
                'name'     => $this->_userName,
                'email'    => $this->_email,
            ]
        );
        $userModel->save();

        $global = App::getInstance()->getSuperGlobalVariable();

        $this->_token = md5(session_id());

        $userSessionModel = new UserSessionModel();
        $userSessionModel->set(
            [
                'userId' => $userModel->getId(),
                'token'  => $this->_token,
                'ip'     => $global->getServerValue('REMOTE_ADDR'),
                'ua'     => $global->getServerValue('HTTP_USER_AGENT'),
            ]
        );
        $userSessionModel->save();

        return $this;
    }
}
