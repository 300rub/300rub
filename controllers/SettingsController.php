<?php

namespace testS\controllers;

use testS\components\Language;
use testS\components\Operation;

/**
 * SettingController
 *
 * @package testS\controllers
 */
class SettingController extends AbstractController
{

    /**
     * Gets settings
     *
     * @return array
     */
    public function getSettings()
    {
        $list = [];

        if ($this->hasSettingsOperation(Operation::SETTING_SEO)) {
            $list["seo"] = [
                "name"       => Language::t("settings", "seo"),
                "controller" => "settings",
                "action"     => "seo",
            ];
        }

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

        return $list;
    }

    public function getSeo()
    {
        // @TODO
    }

    public function updateSeo()
    {
        // @TODO
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