<?php

namespace testS\controllers\user;

use testS\application\App;
use testS\application\components\Db;
use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\_abstract\AbstractModel;
use testS\models\user\UserModel;
use testS\models\user\UserSessionModel;

/**
 * Gets all user sessions
 *
 * Returns array "result" => a list of sessions for current user
 */
class GetSessionsController extends AbstractController
{

    /**
     * Runs controller
     *
     * @throws BadRequestException
     * @throws NotFoundException
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $this->checkData(
            [
                'id' => [self::NOT_EMPTY],
            ]
        );

        $userId = (int)$this->get('id');

        if ($userId !== App::web()->getUser()->getId()) {
            $this->checkSettingsOperation(
                Operation::SETTINGS_USER_VIEW_SESSIONS
            );
        }

        $user = $this->_getUserModel($userId);

        $canDelete = true;
        if ($userId !== App::web()->getUser()->getId()) {
            $canDelete = false;
            if ($user->isOwner() === false) {
                $canDelete = $this->hasSettingsOperation(
                    Operation::SETTINGS_USER_DELETE_SESSIONS
                );
            }
        }

        $language = App::web()->getLanguage();

        return [
            'title'     => $language->getMessage('user', 'sessions'),
            'id'        => $userId,
            'labels'    => [
                'token'
                    => $language->getMessage('user', 'token'),
                'lastActivity'
                    => $language->getMessage('user', 'lastActivity'),
                'platform'
                    => $language->getMessage('user', 'platform'),
                'browser'
                    => $language->getMessage('user', 'browser'),
                'online'
                    => $language->getMessage('user', 'online'),
                'current'
                    => $language->getMessage('user', 'current'),
                'delete'
                    => $language->getMessage('common', 'delete'),
                'deleteAllSessions'
                    => $language->getMessage('user', 'deleteAllSessions'),
                'deleteConfirm'     => [
                    'text' => $language->getMessage(
                        'user',
                        'deleteSessionConfirmText'
                    ),
                    'yes'  => $language->getMessage(
                        'user',
                        'deleteSessionConfirmYes'
                    ),
                    'no'   => $language->getMessage(
                        'common',
                        'no'
                    ),
                ],
                'deleteAllConfirm'  => [
                    'text' => $language->getMessage(
                        'user',
                        'deleteAllSessionsConfirmText'
                    ),
                    'yes'  => $language->getMessage(
                        'user',
                        'deleteAllSessionsConfirmYes'
                    ),
                    'no'   => $language->getMessage(
                        'common',
                        'no'
                    ),
                ]
            ],
            'list'      => $this->_getList($userId),
            'canDelete' => $canDelete
        ];
    }

    /**
     * Gets list
     *
     * @param integer $userId User ID
     *
     * @return array
     */
    private function _getList($userId)
    {
        $userSessionModels = $this->_getUserSessionModels($userId);

        $list = [];
        foreach ($userSessionModels as $userSessionModel) {
            $parsedUserAgent = parse_user_agent(
                $userSessionModel->get('ua')
            );

            $isCurrent = false;
            $token = App::web()->getUser()->getToken();
            if ($userSessionModel->get('token') === $token) {
                $isCurrent = true;
            }

            $list[] = [
                'token'        => $userSessionModel->get('token'),
                'ip'           => $userSessionModel->get('ip'),
                'lastActivity'
                    => $userSessionModel->getFormattedLastActivity(),
                'platform'     => $parsedUserAgent['platform'],
                'browser'      => $parsedUserAgent['browser'],
                'version'      => $parsedUserAgent['version'],
                'isCurrent'    => $isCurrent,
                'isOnline'     => $userSessionModel->isOnline()
            ];
        }

        return $list;
    }

    /**
     * Gets user model
     *
     * @param integer $userId User ID
     *
     * @return UserModel
     *
     * @throws NotFoundException
     */
    private function _getUserModel($userId)
    {
        $user = new UserModel();
        $user = $user->byId($userId)->find();
        if ($user instanceof UserModel === false) {
            throw new NotFoundException(
                'Unable to find user with ID: {id}',
                [
                    'id' => $userId
                ]
            );
        }

        return $user;
    }

    /**
     * Gets user session models
     *
     * @param integer $userId User ID
     *
     * @return AbstractModel[]|UserSessionModel[]
     */
    private function _getUserSessionModels($userId)
    {
        $userSessionModels = new UserSessionModel();
        $userSessionModels
            ->byUserId($userId)
            ->ordered('lastActivity', Db::DEFAULT_ALIAS, true);
        return $userSessionModels->findAll();
    }
}
