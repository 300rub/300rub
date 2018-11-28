<?php

namespace ss\controllers\page;

use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Favicon Controller
 */
class FaviconController extends AbstractPageController
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
