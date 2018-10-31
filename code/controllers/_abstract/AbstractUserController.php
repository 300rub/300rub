<?php

namespace ss\controllers\_abstract;

use ss\application\App;
use ss\application\components\user\User;
use ss\application\exceptions\AccessException;
use ss\models\user\UserModel;

/**
 * Abstract class for working with user
 */
abstract class AbstractUserController extends AbstractDataController
{

    /**
     * Flag is user
     *
     * @return bool
     */
    protected function isUser()
    {
        $user = App::getInstance()->getUser();
        return $user instanceof User;
    }

    /**
     * Checks user
     *
     * @return AbstractOperationController
     *
     * @throws AccessException
     */
    protected function checkUser()
    {
        if ($this->isUser() === false) {
            throw new AccessException('User is null');
        }

        $type = App::getInstance()->getUser()->getType();
        if ($type === UserModel::TYPE_BLOCKED) {
            throw new AccessException('User is blocked');
        }

        return $this;
    }

    /**
     * Gets user operations
     *
     * @return array
     */
    protected function getUserOperations()
    {
        $user = App::getInstance()->getUser();
        if ($user instanceof User === false) {
            return [];
        }

        return App::getInstance()->getUser()->getOperations();
    }

    /**
     * Gets user flag is full access
     *
     * @return bool
     */
    protected function isFullAccess()
    {
        $user = App::getInstance()->getUser();
        if ($user instanceof User === false) {
            return false;
        }

        if ($user->getType() === UserModel::TYPE_OWNER
            || $user->getType() === UserModel::TYPE_FULL
        ) {
            return true;
        }

        return false;
    }

    /**
     * Gets user flag is blocked
     *
     * @return bool
     */
    protected function isBlocked()
    {
        $user = App::getInstance()->getUser();
        if ($user instanceof User === false) {
            return true;
        }

        return $user->getType() === UserModel::TYPE_BLOCKED;
    }
}
