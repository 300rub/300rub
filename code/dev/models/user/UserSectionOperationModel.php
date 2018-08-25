<?php

namespace ss\models\user;


use ss\application\components\db\Table;
use ss\models\user\_base\AbstractUserSectionOperationModel;

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
