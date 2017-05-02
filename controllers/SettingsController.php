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

        $list["users"] = [
            "name"       => Language::t("settings", "users"),
            "controller" => "user",
            "action"     => "users",
        ];

        if ($this->hasSettingsOperation(Operation::SETTINGS_ICON)) {
            $list["icon"] = [
                "name"       => Language::t("settings", "icon"),
                "controller" => "settings",
                "action"     => "icon",
            ];
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