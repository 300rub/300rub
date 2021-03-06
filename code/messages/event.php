<?php

use ss\application\components\common\Language;

return [
    'categorySections'                         => [
        Language::LANGUAGE_EN_ID => 'Sections',
        Language::LANGUAGE_RU_ID => 'Разделы',
    ],
    'categorySettings'                         => [
        Language::LANGUAGE_EN_ID => 'Settings',
        Language::LANGUAGE_RU_ID => 'Настройки',
    ],
    'categoryBlockText'                        => [
        Language::LANGUAGE_EN_ID => 'Blocks. Text',
        Language::LANGUAGE_RU_ID => 'Блоки. Текст',
    ],
    'categoryBlockImage'                       => [
        Language::LANGUAGE_EN_ID => 'Blocks. Image',
        Language::LANGUAGE_RU_ID => 'Блоки. Изображение',
    ],
    'settingsCodeHeader'                       => [
        Language::LANGUAGE_EN_ID => 'Code inside the tag <header>',
        Language::LANGUAGE_RU_ID => 'Код внутри тега <header>',
    ],
    'settingCodeBodyTop'                       => [
        Language::LANGUAGE_EN_ID => 'Code at the end of the tag <body>',
        Language::LANGUAGE_RU_ID => 'Код вначале тега <body>',
    ],
    'settingsCodeBodyBottom'                   => [
        Language::LANGUAGE_EN_ID => 'Code at the end of the tag <body>',
        Language::LANGUAGE_RU_ID => 'Код вконце тега <body>',
    ],
    'blockCreatedEventMask'                    => [
        Language::LANGUAGE_EN_ID => 'Created block "%s"',
        Language::LANGUAGE_RU_ID => 'Создан блок "%s"',
    ],
    'blockDuplicatedEventMask'                 => [
        Language::LANGUAGE_EN_ID => 'Duplicated block "%s"',
        Language::LANGUAGE_RU_ID => 'Продублирован блок "%s"',
    ],
    'blockDeletedEventMask'                    => [
        Language::LANGUAGE_EN_ID => 'Deleted block "%s"',
        Language::LANGUAGE_RU_ID => 'Удален блок "%s"',
    ],
    'blockSettingsUpdatedEventMask'            => [
        Language::LANGUAGE_EN_ID => 'Updated settings for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлены настройки для блока "%s"',
    ],
    'blockSettingsUpdatedNameChangedEventMask' => [
        Language::LANGUAGE_EN_ID
        => 'Block name changed from "%s" to "%s". Updated settings.',
        Language::LANGUAGE_RU_ID
        => 'Название блока изменено с "%s" на "%s". Настройки изменены',
    ],
    'blockContentChangedEventMask'             => [
        Language::LANGUAGE_EN_ID => 'Updated content for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлен контент блока "%s"',
    ],
    'blockDesignChangedEventMask'              => [
        Language::LANGUAGE_EN_ID => 'Updated design for block "%s"',
        Language::LANGUAGE_RU_ID => 'Обновлен дизайн блока "%s"',
    ],
    'imageAlbumCreated'                        => [
        Language::LANGUAGE_EN_ID => 'Created album "%s" for block "%s"',
        Language::LANGUAGE_RU_ID => 'Создан альбом "%s" для блока "%s"',
    ],
    'imageAlbumDeleted'                        => [
        Language::LANGUAGE_EN_ID => 'Deleted album "%s" for block "%s"',
        Language::LANGUAGE_RU_ID => 'Удален альбом "%s" для блока "%s"',
    ],
    'imageUploaded'                            => [
        Language::LANGUAGE_EN_ID => 'Uploaded image "%s" for block "%s"',
        Language::LANGUAGE_RU_ID => 'Загружено изображение "%s" для блока"%s"',
    ],
    'imageDeleted'                             => [
        Language::LANGUAGE_EN_ID => 'Deleted image "%s" for block "%s"',
        Language::LANGUAGE_RU_ID => 'Удалено изображение "%s" для блока"%s"',
    ],
    'imagesSorted'                             => [
        Language::LANGUAGE_EN_ID => 'Images ordered for block "%s"',
        Language::LANGUAGE_RU_ID => 'Отсортированы изображения для блока"%s"',
    ],
    'albumsSorted'                             => [
        Language::LANGUAGE_EN_ID => 'Albums ordered for block "%s"',
        Language::LANGUAGE_RU_ID => 'Отсортированы альбомы для блока"%s"',
    ],
    'imageCropped'                             => [
        Language::LANGUAGE_EN_ID => 'Image changed "%s" for block "%s"',
        Language::LANGUAGE_RU_ID => 'Изменено изображение "%s" для блока"%s"',
    ],
    'imageData'                                => [
        Language::LANGUAGE_EN_ID => 'Image data changed "%s" for block "%s"',
        Language::LANGUAGE_RU_ID
            => 'Изменены данные изображения "%s" для блока"%s"',
    ],
    'albumData'                                => [
        Language::LANGUAGE_EN_ID => 'Album data changed "%s" for block "%s"',
        Language::LANGUAGE_RU_ID
            => 'Изменены данные альбома "%s" для блока"%s"',
    ],
];
