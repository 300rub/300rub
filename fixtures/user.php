<?php

use models\UserModel;

return [
    1 => [
        "login"    => "login",
        "password" => UserModel::createPasswordHash("password"),
    ]
];