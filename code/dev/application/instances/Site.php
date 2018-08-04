<?php

namespace ss\application\instances;

use ss\application\instances\_abstract\AbstractApplication;
use ss\controllers\site\SiteController;

/**
 * Class for working with Site application
 */
class Site extends AbstractApplication
{

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $siteController = new SiteController();
        echo $siteController->run();
    }
}
