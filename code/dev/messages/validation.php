<?php

use ss\application\components\common\Language;

return [
    'required'          => [
        Language::LANGUAGE_EN_ID => 'The field can not be empty',
        Language::LANGUAGE_RU_ID => 'Поле должно быть заполнено',
    ],
    'maxLength'               => [
        Language::LANGUAGE_EN_ID => "The field's length is too long",
        Language::LANGUAGE_RU_ID => 'Поле слишком длинное',
    ],
    'minLength'               => [
        Language::LANGUAGE_EN_ID => "The field's length is too small",
        Language::LANGUAGE_RU_ID => 'Слишком короткое значение',
    ],
    'alias'               => [
        Language::LANGUAGE_EN_ID
            => 'The field should consist of ' .
                'Latin characters, numbers and hyphens',
        Language::LANGUAGE_RU_ID
            => 'Поле должно состоять из латинских символов, чисел и тире',
    ],
    'ip'               => [
        Language::LANGUAGE_EN_ID => 'Incorrect ip address',
        Language::LANGUAGE_RU_ID => '',
    ],
    'email'     => [
        Language::LANGUAGE_EN_ID => 'Incorrect email',
        Language::LANGUAGE_RU_ID => 'Неверный email',
    ],
    'unique' => [
        Language::LANGUAGE_EN_ID => 'The field value must be unique',
        Language::LANGUAGE_RU_ID => 'Такое значение уже существует. Попробуйте другое.',
    ],
    'latinDigitUnderscoreHyphen' => [
        Language::LANGUAGE_EN_ID
            => 'String should consists of latin characters, ' .
                'digits, underscores and hyphens',
        Language::LANGUAGE_RU_ID
            => 'Поле должно состоять из латинских символов, ' .
                'цифр, тире или нижнего подчеркивания',
    ]
];
