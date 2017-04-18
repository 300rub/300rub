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
        $this->checkAnySettingsOperation();

        $list = [];

        if ($this->hasSettingsOperation(Operation::SETTING_ICON)) {
            $list["icon"] = [
                "name"       => Language::t("settings", "icon"),
                "controller" => "settings",
                "action"     => "icon",
            ];
        }

        if ($this->hasSettingsOperation(Operation::SETTING_USERS)) {
            $list["users"] = [
                "name"       => Language::t("settings", "users"),
                "controller" => "user",
                "action"     => "users",
            ];
        }

        return ["result" => $list];
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