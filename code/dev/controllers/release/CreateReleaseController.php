<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;

/**
 * Creates a release
 */
class CreateReleaseController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $language = App::getInstance()->getLanguage();

        return [
            'aaa' => 'ccc'
        ];
    }
}
