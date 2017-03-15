<?php

use testS\models\UserModel;

return [
    1 => [
        "login"    => "owner",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "isOwner"  => true,
        "name"     => "Owner",
        "email"    => "owner@email.com",
    ],
    2 => [
        "login"    => "admin",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "name"     => "Admin",
        "email"    => "admin@email.com",
    ],
    3 => [
        "login"    => "user",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "name"     => "User",
        "email"    => "user@email.com",
    ]
];