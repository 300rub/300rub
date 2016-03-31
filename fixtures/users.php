<?php

use models\UserModel;

return [
    1 => [
        "login"    => "1",
        "password" => UserModel::getPassword(1),
    ]
];