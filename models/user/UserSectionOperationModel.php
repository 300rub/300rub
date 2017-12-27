<?php

namespace testS\models\user;

use testS\application\components\Db;
use testS\models\user\_abstract\AbstractUserSectionOperationModel;

/**
 * Model for working with table "userSectionOperations"
 */
class UserSectionOperationModel extends AbstractUserSectionOperationModel
{

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId User ID
     *
     * @return UserSectionOperationModel
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
