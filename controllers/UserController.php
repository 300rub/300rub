<?php

namespace testS\controllers;

use testS\components\exceptions\BadRequestException;
use testS\models\UserModel;

/**
 * UserController
 *
 * @package testS\controllers
 */
class UserController extends AbstractController
{


    public function getToken()
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

        return ["user" => $userModel];
    }
}