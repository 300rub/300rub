<?php

namespace testS\models\user;

use testS\application\components\Db;
use testS\models\user\_abstract\AbstractUserBlockOperationModel;

/**
 * Model for working with table "userBlockOperations"
 */
class UserBlockOperationModel extends AbstractUserBlockOperationModel
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId
     *
     * @return UserBlockOperationModel
     */
    public function byUserId($userId)
    {
        $this->getDb()->addWhere(
            sprintf(
                "%s.userId = :userId",
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter("userId", $userId);

        return $this;
    }
}