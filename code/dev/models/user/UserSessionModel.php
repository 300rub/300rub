<?php

namespace ss\models\user;

use ss\application\components\db\Table;
use ss\models\user\_base\AbstractUserSessionModel;

/**
 * Model for working with table "userSessions"
 */
class UserSessionModel extends AbstractUserSessionModel
{

    /**
     * Online value in seconds (10 min)
     */
    const ONLINE_VALUE = 600;

    /**
     * Finds by token
     *
     * @param string $token Token
     *
     * @return UserSessionModel
     */
    public function byToken($token)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.token = :token',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('token', $token);

        return $this;
    }

    /**
     * Finds except token
     *
     * @param string $token Token
     *
     * @return UserSessionModel
     */
    public function exceptToken($token)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.token != :token',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('token', $token);

        return $this;
    }

    /**
     * Finds by user ID
     *
     * @param int $userId User ID
     *
     * @return UserSessionModel
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

    /**
     * Gets formatted last Activity
     *
     * @return string
     */
    public function getFormattedLastActivity()
    {
        $lastActivity = $this->get('lastActivity');
        if ($lastActivity instanceof \DateTime === false) {
            return '';
        }

        return $lastActivity->format('d/m/Y H:i');
    }

    /**
     * Flag is online
     *
     * @return bool
     */
    public function isOnline()
    {
        $lastActivity = $this->get('lastActivity');
        if ($lastActivity instanceof \DateTime === false) {
            return false;
        }

        return (time() - $lastActivity->getTimestamp()) < self::ONLINE_VALUE;
    }
}
