<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\db\Db;
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
     * Site Model
     *
     * @var SiteModel
     */
    private $_siteModel = null;

    /**
     * User token
     *
     * @var string
     */
    private $_token = null;
    
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

        try {
            $this->_updateSiteModel();

            $errors = $this->_siteModel->getParsedErrors();
            if (count($errors) > 0) {
                return [
                    'errors' => $errors
                ];
            }

            $this->_createUser();

            $method = 'http';
            $isHttps = App::getInstance()
                ->getSuperGlobalVariable()
                ->isHttps();
            if ($isHttps === true) {
                $method = 'https';
            }

            $url = sprintf(
                '%s://%s.%s?token=%s',
                $method,
                $this->_siteModel->get('name'),
                App::getInstance()
                    ->getConfig()
                    ->getValue(['host']),
                $this->_token
            );

            App::getInstance()->getDb()->commitAll();

            return [
                'result' => true,
                'url'    => $url
            ];
        } catch (\Exception $e) {
            App::getInstance()->getDb()->rollBackAll();
            throw $e;
        }
    }

    /**
     * Creates user
     *
     * @return CreateSiteController
     */
    private function _createUser()
    {
        $dbObject = App::getInstance()->getDb();

        $dbName = $this->_siteModel->get('dbName');

        $dbObject
            ->addPdo(
                $this->_siteModel->get('dbHost'),
                $this->_siteModel->get('dbUser'),
                $this->_siteModel->get('dbPassword'),
                $dbObject->getWriteDbName(
                    $dbName
                )
            )
            ->beginTransaction(
                $dbObject->getWriteDbName(
                    $dbName
                )
            );

        $userModel = new UserModel($dbObject);
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

        $this->_token = md5(session_id());

        $userSessionModel = new UserSessionModel($dbObject);
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

    /**
     * Updates site model
     *
     * @return CreateSiteController
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

        $this->_siteModel = new SiteModel();
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
