<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;

/**
 * Deletes all user sessions except current
 *
 * Removed DR record and memcached record
 */
class DeleteSessionsController extends AbstractController
{

    /**
     * Runs controller
     *
     * @throws BadRequestException
     * @throws AccessException
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $userId = (int)$this->get('id');
        $userSessionModels = $this->_getUserSessionModels($userId);

        foreach ($userSessionModels as $userSessionModel) {
            App::getInstance()
                ->getMemcached()
                ->delete($userSessionModel->get('token'));
            $userSessionModel->delete();
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets user session models
     *
     * @param integer $userId User ID
     *
     * @return AbstractModel[]|UserSessionModel[]
     *
     * @throws AccessException
     */
    private function _getUserSessionModels($userId)
    {
        $user = App::getInstance()->getUser();

        if ($userId === 0
            || $userId === $user->getId()
        ) {
            $userSessionModels = new UserSessionModel();
            $userSessionModels
                ->byUserId($userId)
                ->exceptToken($user->getToken());
            return $userSessionModels->findAll();
        }

        $this->checkSettingsOperation(
            Operation::SETTINGS_USER_DELETE_SESSIONS
        );

        $userModel = $this->_getUserModel($userId);

        if ($userModel->isOwner() === true
            && $user->isOwner() === false
        ) {
            throw new AccessException(
                'Unable to remove sessions for owner'
            );
        }

        $userSessionModels = new UserSessionModel();
        $userSessionModels->byUserId($userId);

        return $userSessionModels->findAll();
    }

    /**
     * Gets user model
     *
     * @param integer $userId User ID
     *
     * @return AbstractModel|UserModel
     *
     * @throws BadRequestException
     */
    private function _getUserModel($userId)
    {
        $userModel = new UserModel();
        $userModel->byId($userId);
        $userModel = $userModel->find();
        if ($userModel === null) {
            throw new BadRequestException(
                'Unable to find UserModel with ID: {id}',
                [
                    'id' => $userId
                ]
            );
        }

        return $userModel;
    }
}
