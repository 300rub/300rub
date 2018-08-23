<?php

namespace ss\models\user;


use ss\models\user\_base\AbstractUserBlockOperationModel;

/**
 * Model for working with table "userBlockOperations"
 */
class UserBlockOperationModel extends AbstractUserBlockOperationModel
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId User ID
     *
     * @return UserBlockOperationModel
     */
    public function byUserId($userId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.userId = :userId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('userId', $userId);

        return $this;
    }
}
