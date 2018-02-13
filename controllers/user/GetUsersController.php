<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\user\UserModel;

/**
 * Gets Users
 */
class GetUsersController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();
        $user = App::web()->getUser();

        $userModel = new UserModel();

        $list = [
            [
                'id'              => $user->getId(),
                'name'            => $user->getName(),
                'email'           => $user->getEmail(),
                'access'          => $userModel->getType($user->getType()),
                'canUpdate'       => true,
                'canDelete'       => false,
                'canViewSessions' => true,
                'isCurrent'       => true,
            ]
        ];

        $canView = $this->hasSettingsOperation(
            Operation::SETTINGS_USER_VIEW
        );
        if ($canView === true) {
            $canUpdate = $this->hasSettingsOperation(
                Operation::SETTINGS_USER_UPDATE
            );
            $canDelete = $this->hasSettingsOperation(
                Operation::SETTINGS_USER_DELETE
            );
            $canViewSessions = $this->hasSettingsOperation(
                Operation::SETTINGS_USER_VIEW_SESSIONS
            );

            $userModels = $this->_getUserModels($user->getId());
            foreach ($userModels as $userModel) {
                $canUpdateUser = false;
                if ($userModel->isOwner() === false) {
                    $canUpdateUser = $canUpdate;
                }

                $canDeleteUser = false;
                if ($userModel->isOwner() === false) {
                    $canDeleteUser = $canDelete;
                }

                $list[] = [
                    'id'              => $userModel->getId(),
                    'name'            => $userModel->get('name'),
                    'email'           => $userModel->get('email'),
                    'access'          => $userModel->getType(),
                    'canUpdate'       => $canUpdateUser,
                    'canDelete'       => $canDeleteUser,
                    'canViewSessions' => $canViewSessions,
                    'isCurrent'       => false,
                ];
            }
        }

        $language = App::web()->getLanguage();

        return [
            'title'  => $language->getMessage('user', 'users'),
            'list'   => $list,
            'canAdd' => $this->hasSettingsOperation(
                Operation::SETTINGS_USER_ADD
            ),
            'labels' => [
                'name'
                    => $language->getMessage('common', 'name'),
                'email'
                    => $language->getMessage('common', 'email'),
                'access'
                    => $language->getMessage('user', 'access'),
                'sessions'
                    => $language->getMessage('user', 'sessions'),
                'edit'
                    => $language->getMessage('common', 'edit'),
                'deleteLabel'
                    => $language->getMessage('common', 'delete'),
                'add'
                    => $language->getMessage('common', 'add'),
                'deleteUserConfirmText'
                    => $language->getMessage('user', 'deleteUserConfirmText'),
                'no'
                    => $language->getMessage('common', 'no'),
            ]
        ];
    }

    /**
     * Gets user models
     *
     * @param integer $userId User ID
     *
     * @return UserModel[]|AbstractModel[]
     */
    private function _getUserModels($userId)
    {
        $userModels = new UserModel();
        $userModels
            ->exceptId($userId)
            ->ordered();
        return $userModels->findAll();
    }
}
