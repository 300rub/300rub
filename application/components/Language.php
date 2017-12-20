<?php

namespace testS\application\components;

use testS\application\exceptions\CommonException;

/**
 * Class contains lib of static functions for working with language
 */
class Language
{

    /**
     * Language ID. English
     */
    const LANGUAGE_EN_ID = 1;

    /**
     * Language alias. English
     */
    const LANGUAGE_EN_ALIAS = 'en';

    /**
     * Language ID. Russian
     */
    const LANGUAGE_RU_ID = 2;

    /**
     * Language alias. Russian
     */
    const LANGUAGE_RU_ALIAS = 'ru';

    /**
     * Active language ID
     *
     * @var integer
     */
    private $_activeId = self::LANGUAGE_EN_ID;

    /**
     * List of languages
     *
     * @var array
     */
    private $_aliasList = [
        self::LANGUAGE_EN_ID => self::LANGUAGE_EN_ALIAS,
        self::LANGUAGE_RU_ID => self::LANGUAGE_RU_ALIAS,
    ];

    /**
     * Gets active ID
     *
     * @return int
     */
    public function getActiveId()
    {
        return $this->_activeId;
    }

    /**
     * Sets active ID
     *
     * @param int $activeId Language ID
     *
     * @return Language
     */
    public function setActiveId($activeId)
    {
        $this->_activeId = $activeId;
        return $this;
    }

    /**
     * Sets ID by alias
     *
     * @param string $name Language alias
     *
     * @throws CommonException
     *
     * @return Language
     */
    public function setIdByAlias($name)
    {
        $languageId = array_search($name, $this->_aliasList);
        if ((bool)$languageId === true) {
            $this->setActiveId($languageId);
            return $this;
        }

        throw new CommonException(
            'Unable to find language with name: {name}',
            [
            'name' => $name
            ]
        );
    }

    /**
     * Gets alias list
     *
     * @return array
     */
    public function getAliasList()
    {
        return $this->_aliasList;
    }

    /**
     * Gets active alias
     *
     * @return string
     */
    public function getActiveAlias()
    {
        if (in_array(self::getActiveId(), $this->_aliasList) === true) {
            return $this->_aliasList[self::getActiveId()];
        }

        return $this->_aliasList[self::LANGUAGE_EN_ID];
    }

    /**
     * Translates message
     *
     * @param string $category Category
     * @param string $key      Key
     *
     * @return string
     */
    public function getMessage($category, $key)
    {
        $messages = include __DIR__ . '/../../messages/' . $category . '.php';
        if (array_key_exists($key, $messages) === true) {
            return $messages[$key][self::getActiveId()];
        }

        return '';
    }

    /**
     * Transliteration
     *
     * @param string $string String for transliteration
     *
     * @return string
     */
    public function getTransliteration($string)
    {
        $converter = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'a',
            'Б' => 'b',
            'В' => 'v',
            'Г' => 'g',
            'Д' => 'd',
            'Е' => 'e',
            'Ё' => 'e',
            'Ж' => 'zh',
            'З' => 'z',
            'И' => 'i',
            'Й' => 'y',
            'К' => 'k',
            'Л' => 'l',
            'М' => 'm',
            'Н' => 'n',
            'О' => 'o',
            'П' => 'p',
            'Р' => 'r',
            'С' => 's',
            'Т' => 't',
            'У' => 'u',
            'Ф' => 'f',
            'Х' => 'h',
            'Ц' => 'c',
            'Ч' => 'ch',
            'Ш' => 'sh',
            'Щ' => 'sch',
            'Ь' => '',
            'Ы' => 'y',
            'Ъ' => '',
            'Э' => 'e',
            'Ю' => 'yu',
            'Я' => 'ya',
        ];

        return strtr($string, $converter);
    }
}