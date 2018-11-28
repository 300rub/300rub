<?php

namespace ss\controllers\page;

use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Robots Controller
 */
class RobotsController extends AbstractPageController
{

    /**
     * Gets robots.txt
     *
     * @return string
     */
    public function run()
    {
        header("Content-Type: text/plain");

        return $this->render(
            'system/robots.txt',
            []
        );
    }
}
