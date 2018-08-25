<?php

namespace ss\models\user;


use ss\application\components\db\Table;
use ss\models\user\_base\AbstractUserBlockGroupOperationModel;

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
