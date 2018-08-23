<?php

namespace ss\models\user;


use ss\models\user\_base\AbstractUserSettingsOperationModel;

/**
 * Model for working with table "userSettingsOperations"
 */
class UserSettingsOperationModel extends AbstractUserSettingsOperationModel
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId User ID
     *
     * @return UserSettingsOperationModel
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
