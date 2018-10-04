<?php

namespace ss\controllers\user;

use ss\application\exceptions\AccessException;
use ss\controllers\_abstract\AbstractController;
use ss\application\components\user\Operation;
use ss\application\App;

/**
 * Gets user buttons
 */
class GetButtonsController extends AbstractController
{

    /**
     * Runs controller
     *
     * @throws AccessException
     *
     * @return array
     */
    public function run()
    {
        if ($this->isUser() === false) {
            throw new AccessException(
                'Unable to get login buttons ' .
                'because user in null'
            );
        }

        $language = App::getInstance()->getLanguage();

        return  [
            'canRelease'        => $this->hasSettingsOperation(
                Operation::SETTINGS_USER_CAN_RELEASE
            ),
            'isDisplaySections' => $this->hasAnySectionOperations(),
            'isDisplayBlocks'   => $this->hasAnyBlockOperations(),
            'labels'            => [
                'logoutYes'
                     => $language->getMessage('user', 'logoutYes'),
                'logoutNo'
                     => $language->getMessage('user', 'logoutNo'),
                'logoutConfirmText'
                     => $language->getMessage('user', 'logoutConfirmText'),
                'releaseButton'
                     => $language->getMessage('release', 'buttonName'),
                'sectionsButton'
                     => $language->getMessage('section', 'buttonName'),
                'blocksButton'
                     => $language->getMessage('block', 'buttonName'),
                'settingsButton'
                     => $language->getMessage('settings', 'buttonName'),
                'helpButton'
                     => $language->getMessage('help', 'buttonName'),
                'logoutButton'
                     => $language->getMessage('user', 'logoutButtonName'),
            ]
        ];
    }
}
