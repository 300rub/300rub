<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\db\sites\Create;
use ss\application\components\db\sites\Update;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * CreateSiteController to get create a new site
 */
class CreateSiteController extends AbstractController
{

    /**
     * Logs file name
     */
    const LOG_FILE_NAME = 'create';

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

        App::getInstance()->getLogger()->info(
            'Creating new site... ' .
            'name: {name}, userName: {userName}, ' .
            'email: {email}, user: {user}, ' .
            'password: {password}, language: {language}',
            [
                'name'     => $this->get('name'),
                'userName' => $this->get('userName'),
                'email'    => $this->get('email'),
                'user'     => $this->get('user'),
                'password' => UserModel::model()->getPasswordHash(
                    $this->get('password')
                ),
                'language' => $this->get('language'),
            ],
            self::LOG_FILE_NAME
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

        $create = new Create();
        $create->create();

        $update = new Update();
        $update
            ->setSiteModel($create->getSiteModel())
            ->setName($this->get('name'))
            ->setUsername($this->get('userName'))
            ->setEmail($this->get('email'))
            ->setUser($this->get('user'))
            ->setPassword($this->get('password'))
            ->setLanguage($this->get('language'));

        return $update->update();
    }
}
