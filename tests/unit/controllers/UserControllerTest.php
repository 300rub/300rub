<?php

namespace testS\tests\unit\controllers;

use testS\models\UserModel;

/**
 * Tests for the controller UserController
 *
 * @package testS\tests\unit\models
 */
class UserControllerTest extends AbstractControllerTest
{

    public function testGetToken()
    {
        $response = $this->getResponse(
            "user",
            "session",
            [
                "user"       => "user",
                "password"   => md5(1 . UserModel::PASSWORD_SALT), // 962855cf2bf384da94ef94d98482a0dd6d6c6374
                "isRemember" => true,
            ],
            "PUT"
        );

        var_dump($response);
        var_dump($this->getStatusCode());
        exit();
    }
}