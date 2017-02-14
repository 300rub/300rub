<?php

namespace testS\controllers;

use DateTime;
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
     *
     * @return array
     *
     * @throws BadRequestException
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
        // @TODO saving $userSessionModel
        $date = new DateTime();
        $userSessionModel = new UserSessionModel();
//        $userSessionModel->set(
//            [
//                "userId" => $userModel->getId(),
//                "token"  => $token,
//                "ip"     => $_SERVER['REMOTE_ADDR'],
//                "ua"     => $_SERVER['HTTP_USER_AGENT'],
//                "lastActivity"   => $date->format("Y-m-d H:i:s") // DateTime Save
//            ]
//        );
        $userSessionModel->save();

        App::web()->setUser($token, $userModel);

        return [
            "result" => true,
            "token" => App::web()->getUser()->getToken(),
            "operations" => App::web()->getUser()->getOperations(),
            "email" => App::web()->getUser()->getEmail(),
        ];
    }
}