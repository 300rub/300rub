<?php

namespace testS\tests\unit\controllers;

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
            "token",
            [
                "user"       => "mike",
                "password"   => md5(1),
                "isRemember" => true
            ]
        );

        var_dump($response);
        var_dump($this->getStatusCode());
        exit();
    }
}