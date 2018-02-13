<?php

namespace ss\application\instances\_abstract;

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
        $pageController = new PageController();
        return $pageController->run();
    }
}
