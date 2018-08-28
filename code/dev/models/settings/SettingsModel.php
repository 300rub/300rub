<?php

namespace ss\models\settings;

use ss\models\settings\_base\AbstractSettingsModel;

/**
 * Model for working with table "settings"
 */
class SettingsModel extends AbstractSettingsModel
{

    /**
     * Gets new model
     *
     * @return SettingsModel
     */
    public static function model()
    {
        return new self;
    }
}
