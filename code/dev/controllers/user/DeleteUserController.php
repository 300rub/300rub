<?php

namespace ss\controllers\user;

use ss\application\components\Operation;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Removes user
 */
class DeleteUserController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws NotFoundException
     * @throws AccessException
     */
    public function run()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_DELETE);

        $this->checkData(
            [
                'id' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $userModel = new UserModel();
        $userModel->byId($this->get('id'));
        $userModel = $userModel->find();
        if ($userModel === null) {
            throw new NotFoundException(
                'Unable to find user by ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        if ($userModel->get('type') === UserModel::TYPE_OWNER) {
            throw new AccessException('Unable to delete owner');
        }

        $userModel->delete();

        return $this->getSimpleSuccessResult();
    }
}
