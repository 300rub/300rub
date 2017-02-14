<?php

use testS\models\UserModel;

return [
    1 => [
        "login"    => "user",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => 1,
        "name"     => "Test User",
        "email"    => "email@email.com",
    ]
];