<?php

use ss\application\components\common\Language;

return [
    'validationTypeFreeText'          => [
        Language::LANGUAGE_EN_ID => 'Free text',
        Language::LANGUAGE_RU_ID => '',
    ],
    'typeTextField' => [
        Language::LANGUAGE_EN_ID => 'Text field',
        Language::LANGUAGE_RU_ID => '',
    ],
    'unsavedWindow'  => [
        Language::LANGUAGE_EN_ID
            => 'Are you sure to close the window? ' .
                'All unsaved changes will be lost.',
        Language::LANGUAGE_RU_ID
            => 'Вы действительно хотите закрыть окно? ' .
                'Все несохраненные изменения будут потеряны.',
    ],
    'unsavedWindowClose'  => [
        Language::LANGUAGE_EN_ID => 'Close',
        Language::LANGUAGE_RU_ID => 'Закрыть окно',
    ],
    'unsavedWindowStay'  => [
        Language::LANGUAGE_EN_ID => 'Stay',
        Language::LANGUAGE_RU_ID => 'Остаться',
    ],
];
