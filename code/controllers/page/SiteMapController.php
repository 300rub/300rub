<?php

namespace ss\controllers\page;

use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Sitemap Controller
 */
class SiteMapController extends AbstractPageController
{

    /**
     * Gets sitemap.xml
     *
     * @return string
     */
    public function run()
    {
        header("Content-type: text/xml");

        return $this->render(
            'system/sitemap.xml',
            []
        );
    }
}
