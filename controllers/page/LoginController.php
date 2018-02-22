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
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        $siteHost = App::web()
            ->getSite()
            ->getInternalHost();
        $host = App::web()
            ->getSuperGlobalVariable()
            ->getServerValue('HTTP_HOST');

        if ($siteHost !== $host) {
            $this->redirect('/login', $siteHost);
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

        $language = App::web()->getLanguage();

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
            = App::web()->getValidator()->getErrorMessages();
        $layoutData['token'] = null;
        $layoutData['isUser'] = false;
        $layoutData['generatedCss'] = [];

        return $this->getContentFromTemplate('page/layout', $layoutData);
    }
}
