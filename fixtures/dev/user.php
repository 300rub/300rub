<?php

use testS\models\user\UserModel;

$userModel = new UserModel();

return [
    1 => [
        "login"    => "owner",
        "password" => $userModel->getPasswordHash("pass", true),
        "type"     => UserModel::TYPE_OWNER,
        "name"     => "Owner",
        "email"    => "owner@email.com",
    ],
    2 => [
        "login"    => "admin",
        "password" => $userModel->getPasswordHash("pass", true),
        "type"     => UserModel::TYPE_FULL,
        "name"     => "Admin",
        "email"    => "admin@email.com",
    ],
    3 => [
        "login"    => "user",
        "password" => $userModel->getPasswordHash("pass", true),
        "type"     => UserModel::TYPE_LIMITED,
        "name"     => "User",
        "email"    => "user@email.com",
    ],
    4 => [
        "login"    => "no-operation",
        "password" => $userModel->getPasswordHash("pass", true),
        "type"     => UserModel::TYPE_LIMITED,
        "name"     => "User with no operations",
        "email"    => "test-operation@email.com",
    ],
    5 => [
        "login"    => "blocked",
        "password" => $userModel->getPasswordHash("pass", true),
        "type"     => UserModel::TYPE_BLOCKED,
        "name"     => "Blocked User",
        "email"    => "blocked@email.com",
    ]
];