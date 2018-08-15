<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\Db;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\system\SiteModel;

/**
 * CreateSiteController to get create a new site
 */
class CreateSiteController extends AbstractController
{

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

        $siteId = 0;
        $errors = [];

        $systemDb = new Db();
        $systemDb->setSystemPdo();
        $systemDb->startTransaction();
        try {
            $siteModel = new SiteModel();
            $siteModel->setDb($systemDb);
            $siteModel->set([
                'name'       => $this->get('name'),
                'language'   => $this->get('language'),
                'email'      => $this->get('email'),
                'dbHost'     => 'tmp',
                'dbUser'     => 'tmp',
                'dbPassword' => 'tmp',
                'dbName'     => 'tmp',
            ]);
            $siteModel->save();

            $errors = $siteModel->getErrors();
            $siteId = $siteModel->getId();

            $systemDb->commitTransaction();
        } catch (\Exception $e) {
            $systemDb->rollbackTransaction();
        }

        return [
            'siteId' => $siteId,
            'errors' => $errors,
        ];
    }
}
