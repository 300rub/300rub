<?php

namespace testS\controllers;

use testS\components\Language;
use testS\components\Operation;

/**
 * SettingController
 *
 * @package testS\controllers
 */
class SettingsController extends AbstractController
{

    /**
     * Gets settings
     *
     * @return array
     */
    public function getSettings()
    {
        $this->checkUser();

        $list = [];

        $list["users"] = Language::t("settings", "users");

        if ($this->hasSettingsOperation(Operation::SETTINGS_ICON)) {
            $list["icon"] = Language::t("settings", "icon");
        }

        return [
            "title"       => Language::t("settings", "settings"),
            "description" => Language::t("settings", "description"),
            "list"        => $list
        ];
    }

    public function getIcon()
    {
        // @TODO
    }

    public function updateIcon()
    {
        // @TODO
    }
}