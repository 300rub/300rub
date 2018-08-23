<?php

namespace ss\models\user;


use ss\models\user\_base\AbstractUserSectionGroupOperationModel as Base;

/**
 * Model for working with table "userSectionGroupOperations"
 */
class UserSectionGroupOperationModel extends Base
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId User ID
     *
     * @return UserSectionGroupOperationModel
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
