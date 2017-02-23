<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\BadRequestException;
use testS\models\UserModel;
use testS\models\UserSessionModel;

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
     */
    public function deleteSession()
    {
        // @TODO
    }

    /**
     * Gets all user sessions
     */
    public function getSessions()
    {
        // @TODO
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