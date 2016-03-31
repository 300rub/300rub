<?php

use components\Language;

return [
    "required"          => [
        Language::LANGUAGE_EN_ID => "The field can not be empty",
        Language::LANGUAGE_RU_ID => "Поле должно быть заполнено",
    ],
    "max"               => [
        Language::LANGUAGE_EN_ID => "The field is too long",
        Language::LANGUAGE_RU_ID => "Поле слишком длинное",
    ],
    "url"               => [
        Language::LANGUAGE_EN_ID => "The field should consist of Latin characters, numbers and dashes",
        Language::LANGUAGE_RU_ID => "Поле должно состоять из латинских символов, чисел и тире",
    ],
    "system"            => [
        Language::LANGUAGE_EN_ID => "Terrible happened, but we already know about it.
            The problem is already at the design stage. We apologize. Try the operation later.",
        Language::LANGUAGE_RU_ID => "Случилось страшное, но мы уже знаем об этом. Проблема уже находится на стадии
            решения. Приносим свои извинения. Попробуйте данную операцию чуть позже.",
    ],
    "loginNotExist"     => [
        Language::LANGUAGE_EN_ID => "User with such login does not exist",
        Language::LANGUAGE_RU_ID => "Пользователя с таким логином не существует",
    ],
    "passwordIncorrect" => [
        Language::LANGUAGE_EN_ID => "Incorrect password",
        Language::LANGUAGE_RU_ID => "Некорректный пароль",
    ],
];