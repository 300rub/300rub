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
        "type"     => UserModel::TYPE_FULL,
        "name"     => "Admin",
        "email"    => "admin@email.com",
    ],
    3 => [
        "login"    => "user",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_LIMITED,
        "name"     => "User",
        "email"    => "user@email.com",
    ],
    4 => [
        "login"    => "no-operation",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_LIMITED,
        "name"     => "User with no operations",
        "email"    => "test-operation@email.com",
    ],
    5 => [
        "login"    => "blocked",
        "password" => sha1(md5("pass" . UserModel::PASSWORD_SALT)),
        "type"     => UserModel::TYPE_BLOCKED,
        "name"     => "Blocked User",
        "email"    => "blocked@email.com",
    ]
];