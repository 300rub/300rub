<?php

namespace ss\models\system;

use ss\models\system\_base\AbstractMigrationModel;

/**
 * Model for working with table "migrations"
 */
class MigrationModel extends AbstractMigrationModel
{

    /**
     * Returns MigrationModel
     *
     * @return MigrationModel
     */
    public static function model()
    {
        return new self;
    }
}
