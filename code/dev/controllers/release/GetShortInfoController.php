<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;

/**
 * Gets release short info
 */
class GetShortInfoController extends AbstractController
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
            'title'         => $language->getMessage('release', 'panelTitle'),
            'description'   => $language->getMessage('release', 'panelDescription'),
            'moreInfoLabel' => $language->getMessage('release', 'moreInfoLabel'),
            'button'        => [
                'label' => $language->getMessage('release', 'applyButton'),
            ]
        ];
    }
}
