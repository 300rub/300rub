<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\application\components\db\Table;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserEventModel;
use ss\models\user\UserModel;

/**
 * Gets release full info
 */
class GetFullInfoController extends AbstractController
{

    /**
     * Limit
     */
    const LIMIT = 500;

    /**
     * A list of users
     *
     * @var array
     */
    private $_userList = [];

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $language = App::getInstance()->getLanguage();

        return [
            'title'     => $language->getMessage('release', 'windowTitle'),
            'events'    => $this->_getEvents(),
            'labels' => [
                'name'     => $language->getMessage('user', 'user'),
                'date'     => $language->getMessage('common', 'date'),
                'type'     => $language->getMessage('common', 'type'),
                'event'    => $language->getMessage('release', 'event'),
                'category' => $language->getMessage('release', 'category'),
            ]
        ];
    }

    /**
     * Gets events
     *
     * @return array
     */
    private function _getEvents()
    {
        $userEvents = $this->_getUserEvents();

        if ($userEvents === 0) {
            return [];
        }

        $this->_setUserList();

        $list = [];
        foreach ($userEvents as $userEvent) {
            $list[] = [
                'name'     => $this->_getUserNameById(
                    $userEvent->get('userId')
                ),
                'date'
                    => $userEvent->get('date')->format('d.m.Y H:i:s'),
                'category' => $userEvent->getCategoryValue(),
                'type'     => $userEvent->getTypeValue(),
                'event'    => $userEvent->get('event')
            ];
        }

        return $list;
    }

    /**
     * Gets user events
     *
     * @return UserEventModel[]
     */
    private function _getUserEvents()
    {
        return UserEventModel::model()
            ->ordered('date', Table::DEFAULT_ALIAS, true)
            ->limit(self::LIMIT)
            ->findAll();
    }

    /**
     * Sets user list
     *
     * @return GetFullInfoController
     */
    private function _setUserList()
    {
        $users = UserModel::model()->findAll();

        $this->_userList = [];
        foreach ($users as $user) {
            $this->_userList[$user->getId()] = $user->get('name');
        }

        return $this;
    }

    /**
     * Gets user name by ID
     *
     * @param int $userId User ID
     *
     * @return string
     */
    private function _getUserNameById($userId)
    {
        if (array_key_exists($userId, $this->_userList) === false) {
            return App::getInstance()
                ->getLanguage()
                ->getMessage('common', 'unknown');
        }

        return $this->_userList[$userId];
    }
}
