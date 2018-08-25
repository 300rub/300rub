<?php

namespace ss\models\user;


use ss\application\components\db\Table;
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
