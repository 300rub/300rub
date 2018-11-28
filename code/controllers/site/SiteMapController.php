<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Sitemap Controller
 */
class SiteMapController extends AbstractController
{

    /**
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        header("Content-type: text/xml");

        return $this->render(
            'site/sitemap.xml',
            []
        );
    }
}
