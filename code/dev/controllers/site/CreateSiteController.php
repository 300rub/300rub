<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\Db;
use ss\application\exceptions\NotFoundException;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\system\SiteModel;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;

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
     * Gets site page
     *
     * @return string
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->checkData(
            [
                'name'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'userName'        => [self::TYPE_STRING, self::NOT_EMPTY],
                'email'           => [self::TYPE_STRING, self::NOT_EMPTY],
                'user'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'password'        => [self::TYPE_STRING, self::NOT_EMPTY],
                'passwordConfirm' => [self::TYPE_STRING, self::NOT_EMPTY],
                'language'        => [self::NOT_EMPTY],
            ]
        );

        if ($this->get('password') !== $this->get('passwordConfirm')) {
            return [
                'userErrors' => [
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
            $this->_updateSiteModel();

            $errors = $this->_siteModel->getParsedErrors();
            if (count($errors) > 0) {
                return [
                    'errors' => $errors
                ];
            }

            $token = md5(session_id());

            $this
                ->_createUser(
                    $token,
                    $this->_siteModel->get('dbName')
                )
                ->_createUser(
                    $token,
                    sprintf(
                        '%sAdmin',
                        $this->_siteModel->get('dbName')
                    )
                );

            $this->_systemDb->commitTransaction();

            $method = 'http';
            $isHttps = App::getInstance()
                ->getSuperGlobalVariable()
                ->isHttps();
            if ($isHttps === true) {
                $method = 'https';
            }

            return [
                'result' => true,
                'url'    => sprintf(
                    '%s://%s.%s?token=%s',
                    $method,
                    $this->_siteModel->get('name'),
                    App::getInstance()
                        ->getConfig()
                        ->getValue(['host']),
                    $token
                )
            ];
        } catch (\Exception $e) {
            $this->_systemDb->rollbackTransaction();

            throw $e;
        }
    }

    /**
     * Creates user
     *
     * @param string $token  Token
     * @param string $dbName DB name
     *
     * @return CreateSiteController
     */
    private function _createUser($token, $dbName)
    {
        $siteDb = new Db();
        $siteDb->setPdo(
            $this->_siteModel->get('dbHost'),
            $this->_siteModel->get('dbUser'),
            $this->_siteModel->get('dbPassword'),
            $dbName
        );

        $userModel = new UserModel($siteDb);
        $userModel->set([
            'login'    => $this->get('user'),
            'password' => $userModel->getPasswordHash(
                $this->get('password'),
                true
            ),
            'type'     => UserModel::TYPE_OWNER,
            'name'     => $this->get('userName'),
            'email'    => $this->get('email'),
        ]);
        $userModel->save();

        $global = App::getInstance()->getSuperGlobalVariable();

        $userSessionModel = new UserSessionModel($siteDb);
        $userSessionModel->set(
            [
                'userId' => $userModel->getId(),
                'token'  => $token,
                'ip'     => $global->getServerValue('REMOTE_ADDR'),
                'ua'     => $global->getServerValue('HTTP_USER_AGENT'),
            ]
        );
        $userSessionModel->save();

        return $this;
    }

    /**
     * Updates site model
     *
     * @return CreateSiteController
     *
     * @throws NotFoundException
     */
    private function _updateSiteModel()
    {
        $this->_siteModel = new SiteModel($this->_systemDb);
        $this->_siteModel = $this->_siteModel->source()->find();
        if ($this->_siteModel === null) {
            throw new NotFoundException('Source site not found');
        }

        $this->_siteModel->set([
            'name'     => $this->get('name'),
            'language' => $this->get('language'),
            'email'    => $this->get('email'),
            'isSource' => false,
        ]);
        $this->_siteModel->save();

        return $this;
    }
}