<?php

use testS\components\Language;

return [
    "required"          => [
        Language::LANGUAGE_EN_ID => "The field can not be empty",
        Language::LANGUAGE_RU_ID => "Поле должно быть заполнено",
    ],
    "max"               => [
        Language::LANGUAGE_EN_ID => "The field's length is too long",
        Language::LANGUAGE_RU_ID => "Поле слишком длинное",
    ],
    "min"               => [
        Language::LANGUAGE_EN_ID => "The field's length is too small",
        Language::LANGUAGE_RU_ID => "",
    ],
    "url"               => [
        Language::LANGUAGE_EN_ID => "The field should consist of Latin characters, numbers and dashes",
        Language::LANGUAGE_RU_ID => "Поле должно состоять из латинских символов, чисел и тире",
    ],
    "loginNotExist"     => [
        Language::LANGUAGE_EN_ID => "User with such login does not exist",
        Language::LANGUAGE_RU_ID => "Пользователя с таким логином не существует",
    ],
    "passwordIncorrect" => [
        Language::LANGUAGE_EN_ID => "Incorrect password",
        Language::LANGUAGE_RU_ID => "Некорректный пароль",
    ],
    "latinDigitUnderscoreHyphen" => [
        Language::LANGUAGE_EN_ID => "String should consists of latin characters, digits, underscores and hyphens",
        Language::LANGUAGE_RU_ID => "",
    ]
];