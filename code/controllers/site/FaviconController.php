<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Favicon Controller
 */
class FaviconController extends AbstractController
{

    /**
     * Gets favicon
     *
     * @return string
     */
    public function run()
    {
        header("Content-Type: image/ico");
        return '';
    }
}
