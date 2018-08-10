<?php

namespace ss\application\components;

use ss\application\exceptions\CommonException;

/**
 * Class for generation values
 */
abstract class ValueGenerator
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
     * Value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Param
     *
     * @var mixed
     */
    protected $param;

    /**
     * Generates value
     *
     * @return mixed
     */
    abstract public function generate();

    /**
     * Generates a value
     *
     * @param string $type  Generator type
     * @param mixed  $value Value
     * @param mixed  $param Additional parameter
     *
     * @return ValueGenerator
     *
     * @throws CommonException
     */
    public static function factory($type, $value, $param = null)
    {
        if (in_array($type, self::$typeList) === false) {
            throw new CommonException(
                'Unable to find value generator type; {type}',
                [
                    'type' => $type
                ]
            );
        }

        $object = new $type;
        $object->value = $value;
        $object->param = $param;

        return $object;
    }
}
