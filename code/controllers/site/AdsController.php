<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Ads Controller
 */
class AdsController extends AbstractController
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
