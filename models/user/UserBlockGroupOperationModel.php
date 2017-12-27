<?php

namespace testS\models\user;

use testS\application\components\Db;
use testS\models\user\_base\AbstractUserBlockGroupOperationModel;

/**
 * Model for working with table "userBlockGroupOperations"
 */
class UserBlockGroupOperationModel extends AbstractUserBlockGroupOperationModel
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId User ID
     *
     * @return UserBlockGroupOperationModel
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
