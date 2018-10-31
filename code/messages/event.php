<?php

use ss\application\components\common\Language;

return [
    'categorySections' => [
        Language::LANGUAGE_EN_ID => 'Sections',
        Language::LANGUAGE_RU_ID => 'Разделы',
    ],
    'categorySettings' => [
        Language::LANGUAGE_EN_ID => 'Settings',
        Language::LANGUAGE_RU_ID => 'Настройки',
    ],
    'categoryBlockText' => [
        Language::LANGUAGE_EN_ID => 'Blocks. Text',
        Language::LANGUAGE_RU_ID => 'Блоки. Текст',
    ],
    'settingsCodeHeader' => [
        Language::LANGUAGE_EN_ID => 'Code inside the tag <header>',
        Language::LANGUAGE_RU_ID => 'Код внутри тега <header>',
    ],
    'settingCodeBodyTop' => [
        Language::LANGUAGE_EN_ID => 'Code at the end of the tag <body>',
        Language::LANGUAGE_RU_ID => 'Код вначале тега <body>',
    ],
    'settingsCodeBodyBottom' => [
        Language::LANGUAGE_EN_ID => 'Code at the end of the tag <body>',
        Language::LANGUAGE_RU_ID => 'Код вконце тега <body>',
    ],
    'blockCreatedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Created block "%s"',
        Language::LANGUAGE_RU_ID => 'Создан блок "%s"',
    ],
    'blockDuplicatedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Duplicated block "%s"',
        Language::LANGUAGE_RU_ID => 'Продублирован блок "%s"',
    ],
    'blockDeletedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Deleted block "%s"',
        Language::LANGUAGE_RU_ID => 'Удален блок "%s"',
    ],
    'blockSettingsUpdatedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Updated settings for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлены настройки для блока "%s"',
    ],
    'blockSettingsUpdatedNameChangedEventMask' => [
        Language::LANGUAGE_EN_ID
            => 'Block name changed from "%s" to "%s". Updated settings.',
        Language::LANGUAGE_RU_ID
            => 'Название блока изменено с "%s" на "%s". Настройки изменены',
    ],
    'blockContentChangedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Updated content for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлен контент блока "%s"',
    ],
    'blockDesignChangedEventMask' => [
        Language::LANGUAGE_EN_ID => 'Updated design for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлен дизайн блока "%s"',
    ],
];
