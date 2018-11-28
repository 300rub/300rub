<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Ads Controller
 */
class AdsController extends AbstractController
{

    /**
     * Gets ads.txt
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
