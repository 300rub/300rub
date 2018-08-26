<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;

/**
 * Gets release full info
 */
class GetFullInfoController extends AbstractController
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
            'title' => $language->getMessage('release', 'windowTitle'),
        ];
    }
}
