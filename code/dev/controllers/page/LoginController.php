<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Login Controller
 */
class LoginController extends AbstractPageController
{

    /**
     * Login alias
     */
    const LOGIN_ALIAS = 'login';

    /**
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        $siteHost = App::getInstance()
            ->getSite()
            ->getInternalHost();
        $host = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue('HTTP_HOST');

        $language = App::getInstance()->getLanguage();

        if ($this->isUser() === true) {
            $this->redirect(
                sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
                $siteHost
            );
        }

        if ($siteHost !== $host) {
            $this->redirect(
                sprintf(
                    '/%s/%s',
                    $language->getActiveAlias(),
                    self::LOGIN_ALIAS
                ),
                $siteHost
            );
        }

        $language = App::getInstance()->getLanguage();

        return $this->render(
            'layout/login',
            [
                'icon'           => '/img/favicon.ico',
                'title'          => $language->getMessage('user', 'loginTitle'),
                'css'            => $this->getCss(),
                'js'             => $this->getJs(),
                'html'           => $this->getHtml(),
                'less'           => $this->getLess(),
                'initJs'         => $this->render(
                    'layout/js/login'
                ),
            ]
        );
    }
}
