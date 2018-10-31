<?php

namespace ss\application\components\valueGenerator;

use ss\application\components\valueGenerator\_abstract\AbstractGenerator;
use ss\application\exceptions\CommonException;

/**
 * Class for generation values
 */
class ValueGenerator
{

    /**
     * Types
     */
    const ARRAY_KEY
        = '\\ss\\application\\components\\valueGenerator\\' .
            'filter\\ArrayKey';
    const BOOL_INT
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\BoolIntValue';
    const BOOL
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\BoolValue';
    const CLEAR_STRIP_TAGS
        = '\\ss\\application\\components\\valueGenerator\\' .
            'modify\\ClearStripTags';
    const COLOR
        = '\\ss\\application\\components\\valueGenerator\\' .
            'filter\\Color';
    const COPY_NAME
        = '\\ss\\application\\components\\valueGenerator\\' .
            'modify\\CopyName';
    const DATETIME
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\DateTimeValue';
    const FLOAT
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\FloatValue';
    const INT
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\IntValue';
    const MAX
        = '\\ss\\application\\components\\valueGenerator\\' .
            'math\\Max';
    const MIN
        = '\\ss\\application\\components\\valueGenerator\\' .
            'math\\Min';
    const MIN_THEN
        = '\\ss\\application\\components\\valueGenerator\\' .
            'math\\MinThen';
    const STRING
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\StringValue';
    const ALIAS
        = '\\ss\\application\\components\\valueGenerator\\' .
            'modify\\Alias';
    const COPY_ALIAS
        = '\\ss\\application\\components\\valueGenerator\\' .
            'modify\\AliasCopy';
    const DATETIME_AS_STRING
        = '\\ss\\application\\components\\valueGenerator\\' .
            'type\\Iso';
    const ORDERED_ARRAY
        = '\\ss\\application\\components\\valueGenerator\\' .
            'modify\\OrderedArrayForJson';

    /**
     * Type list
     *
     * @var array
     */
    protected static $typeList = [
        self::MIN,
        self::MAX,
        self::MIN_THEN,
        self::COLOR,
        self::CLEAR_STRIP_TAGS,
        self::COPY_NAME,
        self::COPY_ALIAS,
        self::ARRAY_KEY,
        self::ALIAS,
        self::STRING,
        self::INT,
        self::FLOAT,
        self::BOOL,
        self::BOOL_INT,
        self::DATETIME,
        self::DATETIME_AS_STRING,
        self::ORDERED_ARRAY,
    ];

    /**
     * Gets a value
     *
     * @param string $type  Generator type
     * @param mixed  $value Value
     * @param mixed  $param Additional parameter
     *
     * @return ValueGenerator
     *
     * @throws CommonException
     */
    public function getValue($type, $value, $param = null)
    {
        return $this->_getObject($type)
            ->setValue($value)
            ->setParam($param)
            ->generate();
    }

    /**
     * Gets object by type
     *
     * @param string $type Type
     *
     * @return AbstractGenerator
     *
     * @throws CommonException
     */
    private function _getObject($type)
    {
        if (in_array($type, self::$typeList) === false) {
            throw new CommonException(
                'Unable to find value generator type; {type}',
                [
                    'type' => $type
                ]
            );
        }

        return new $type;
    }
}
