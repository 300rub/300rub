<?php

namespace ss\models\user;

use ss\models\user\_base\AbstractUserEventModel;

/**
 * Model for working with table "userEvents"
 */
class UserEventModel extends AbstractUserEventModel
{

    /**
     * Gets UserEventModel
     *
     * @return UserEventModel
     */
    public static function model()
    {
        return new self;
    }
}
