<?php

namespace ss\controllers\settings;

use ss\application\App;
use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;

/**
 * Gets settings
 */
class GetSettingsController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $language = App::web()->getLanguage();

        $list = [];

        $list['users'] = $language->getMessage('settings', 'users');

        if ($this->hasSettingsOperation(Operation::SETTINGS_ICON) === true) {
            $list['icon'] = $language->getMessage('settings', 'icon');
        }

        return [
            'title'       => $language->getMessage('settings', 'settings'),
            'description' => $language->getMessage('settings', 'description'),
            'list'        => $list
        ];
    }
}
