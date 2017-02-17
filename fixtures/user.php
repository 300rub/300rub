<?php

use testS\models\UserModel;

return [
    1 => [
        "login"    => "owner",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_OWNER,
        "name"     => "Owner",
        "email"    => "owner@email.com",
    ],
    2 => [
        "login"    => "admin",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_ADMINISTRATOR,
        "name"     => "Admin",
        "email"    => "admin@email.com",
    ],
    3 => [
        "login"    => "user",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_USER,
        "name"     => "User",
        "email"    => "user@email.com",
    ]
];