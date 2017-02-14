<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\BadRequestException;
use testS\models\UserModel;
use DateTime;
use testS\models\UserSessionModel;

/**
 * UserController
 *
 * @package testS\controllers
 */
class UserController extends AbstractController
{


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
                "sessionId"   => session_id(),
                "sessionName" => session_name(),
                "result"      => false,
                "user"        => App::web()->getUser()
            ];
        }

        if ($userModel->get("password") !== sha1($data["password"])) {
            return [
                "result" => false
            ];
        }

        $token = md5(microtime() . rand(1, 1000));
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $date = new DateTime();
        $userSessionModel = new UserSessionModel();
        $userSessionModel->set([
            "userId" => $userModel->getId(),
            "token" => $token,
            "ip" => $_SERVER['REMOTE_ADDR'],
            "ua" => $ua,
            "date" => $date->format("Y-m-d H:i:s")
        ]);

        return [
            "token" => $token,
            "id" => $ip,
            "ua" => $ua,
            "date" => $date->format("Y-m-d H:i:s"),
            "model" => $userSessionModel->get()
        ];
    }
}