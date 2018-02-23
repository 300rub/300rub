<?php

namespace ss\application\instances\_abstract;

use ss\controllers\page\LoginController;
use ss\controllers\page\LogoutController;
use ss\controllers\page\PageController;

/**
 * Abstract class to display page
 */
abstract class AbstractWebPage extends AbstractApplication
{

    /**
     * Gets Page output
     *
     * @return string
     */
    protected function processPage()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $requestUri = trim($requestUri, '/');

        if ($requestUri === 'login') {
            $loginController = new LoginController();
            return $loginController->run();
        }

        $pageController = new PageController();
        return $pageController->run();
    }
}
