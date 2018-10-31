<?php

namespace ss\models\user;

use ss\application\components\db\Table;
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
        $this->getTable()->addWhere(
            sprintf(
                '%s.userId = :userId',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('userId', $userId);

        return $this;
    }
}
