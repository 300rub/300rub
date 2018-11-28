<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * Robots Controller
 */
class RobotsController extends AbstractController
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
