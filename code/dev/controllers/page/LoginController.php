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

        $content = $this->getContentFromTemplate(
            'templates/templates',
            [
                'isUser' => false
            ]
        );
        $content .= $this->getContentFromTemplate(
            'page/login'
        );

        $this->setStaticMap('static');

        $language = App::getInstance()->getLanguage();

        $layoutData = [];
        $layoutData['content'] = $content;
        $layoutData['title'] = $language->getMessage('user', 'loginTitle');
        $layoutData['keywords'] = '';
        $layoutData['description'] = '';
        $layoutData['css'] = $this->getCss();
        $layoutData['js'] = $this->getJs();
        $layoutData['less'] = $this->getLess();
        $layoutData['language'] = $language->getActiveId();
        $layoutData['errorMessages']
            = App::getInstance()->getValidator()->getErrorMessages();
        $layoutData['token'] = null;
        $layoutData['sectionId'] = 0;
        $layoutData['isUser'] = false;
        $layoutData['generatedCss'] = [];
        $layoutData['generatedJs'] = [];
        $layoutData['version'] = $this->getVersion();


        return $this->getContentFromTemplate('page/layout', $layoutData);
    }
}
