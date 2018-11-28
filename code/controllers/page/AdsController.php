<?php

namespace ss\controllers\page;

use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Ads Controller
 */
class AdsController extends AbstractPageController
{

    /**
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        header("Content-Type: text/plain");

        return $this->render(
            'system/ads.txt',
            []
        );
    }
}
