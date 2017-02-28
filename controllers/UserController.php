<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\models\UserModel;
use testS\models\UserSessionModel;
use testS\components\User;

/**
 * UserController
 *
 * @package testS\controllers
 */
class UserController extends AbstractController
{

    /**
     * Adds user session. Sets User
     */
    public function addSession()
    {
        $data = $this->getData();

        if (empty($data["user"])
            || empty($data["password"])
            || !isset($data["isRemember"])
            || !is_string($data["user"])
            || !is_string($data["password"])
            || !is_bool($data["isRemember"])
            || strlen($data["password"]) !== 32
        ) {
            throw new BadRequestException(
                "Incorrect request for user authorization. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $userModel = (new UserModel())->byLogin($data["user"])->find();
        if (!$userModel instanceof UserModel) {
            return [
                "result" => false,
            ];
        }

        if ($userModel->get("password") !== sha1($data["password"])) {
            return [
                "result" => false
            ];
        }

        $token = md5(session_id());

        $userSessionModel = (new UserSessionModel())->byToken($token)->find();
        if ($userSessionModel instanceof UserSessionModel) {
            return ["token" => $token];
        } else {
            $userSessionModel = new UserSessionModel();
            $userSessionModel->set(
                [
                    "userId" => $userModel->getId(),
                    "token"  => $token,
                    "ip"     => $_SERVER['REMOTE_ADDR'],
                    "ua"     => $_SERVER['HTTP_USER_AGENT'],
                ]
            );
            $userSessionModel->save();
        }

        App::web()->setUser($token, $userModel);

        if ($data["isRemember"] === true) {
            setcookie("token", $token);
        }

        return ["token" => $token];
    }

    /**
     * Removes user session
     *
     * Removes DB record and Memcache
     */
    public function deleteSession()
    {
        $user = App::web()->getUser();
        if (!$user instanceof User) {
            return [
                "result" => true
            ];
        }

        $data = $this->getData();
        if (!array_key_exists("token", $data)) {
            App::web()->getMemcached()->delete($user->getToken());

            unset($_COOKIE['token']);
            setcookie('token', '', time() - 3600);

            $userSessionModel = (new UserSessionModel())->byToken($user->getToken())->find();
            if ($userSessionModel instanceof UserSessionModel) {
                $userSessionModel->delete();
            }

            return [
                "result" => true
            ];
        }

        $token = $data["token"];

        if (!is_string($token)
            || strlen($token) !== 32
        ) {
            throw new BadRequestException(
                "Incorrect token: {token} to delete UserSession",
                [
                    "token" => $token
                ]
            );
        }

        $userSessionModel = (new UserSessionModel())->byToken($token)->find();
        if ($userSessionModel instanceof UserSessionModel) {
            if ($userSessionModel->get("userId") !== $user->getId()) {
                throw new AccessException(
                    "Unable to delete UserSession " .
                    "with token: {token}, ID: {id}, userId: {userId} by user with ID: {currentUserId}",
                    [
                        "token"         => $token,
                        "id"            => $userSessionModel->getId(),
                        "userId"        => $userSessionModel->get("userId"),
                        "currentUserId" => $user->getId(),
                    ]
                );
            }

            App::web()->getMemcached()->delete($token);
            $userSessionModel->delete();
        }

        return [
            "result" => true
        ];
    }

    /**
     * Gets all user sessions
     */
    public function getSessions()
    {
        $this->checkUser();

        $userSessionModels = (new UserSessionModel())
            ->byUserId(App::web()->getUser()->getId())
            ->ordered()
            ->findAll();

        $list = [];
        foreach ($userSessionModels as $userSessionModel) {
            $parsedUserAgent = parse_user_agent($userSessionModel->get("ua"));
            $list[] = [
                "ip"           => $userSessionModel->get("ip"),
                "token"        => $userSessionModel->get("token"),
                "lastActivity" => $userSessionModel->getFormattedLastActivity(),
                "platform"     => $parsedUserAgent["platform"],
                "browser"      => $parsedUserAgent["browser"],
                "version"      => $parsedUserAgent["version"],
                "isCurrent"    => $userSessionModel->get("token") === App::web()->getUser()->getToken(),
                "isOnline"     => $userSessionModel->isOnline()
            ];
        }

        return ["result" => $list];
    }

    /**
     * Deletes all user sessions
     */
    public function deleteSessions()
    {
        // @TODO
    }

    /**
     * Adds user
     */
    public function addUser()
    {
        // @TODO
    }

    /**
     * Gets user
     */
    public function getUser()
    {
        // @TODO
    }

    /**
     * Updates user
     */
    public function updateUser()
    {
        // @TODO
    }

    /**
     * Deletes user
     */
    public function deleteUser()
    {
        // @TODO
    }
}