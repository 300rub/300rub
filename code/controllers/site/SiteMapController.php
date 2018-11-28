<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Sitemap Controller
 */
class SiteMapController extends AbstractController
{

    /**
     * Login alias
     */
    const SITEMAP_ALIAS = 'sitemap.xml';

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
