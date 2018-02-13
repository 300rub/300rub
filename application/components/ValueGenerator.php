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
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'filter\\ArrayKey';
    const BOOL_INT
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\BoolIntValue';
    const BOOL
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\BoolValue';
    const CLEAR_STRIP_TAGS
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'modify\\ClearStripTags';
    const COLOR
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'filter\\Color';
    const COPY_NAME
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'modify\\CopyName';
    const DATETIME
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\DateTimeValue';
    const FLOAT
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\FloatValue';
    const INT
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\IntValue';
    const MAX
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'math\\Max';
    const MIN
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'math\\Min';
    const MIN_THEN
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'math\\MinThen';
    const STRING
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\StringValue';
    const URL
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'modify\\Url';
    const COPY_URL
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'modify\\UrlCopy';
    const DATETIME_AS_STRING
        = '\\ss\\application\\components\\ValueGenerator\\' .
            'type\\Iso';
    const ORDERED_ARRAY
        = '\\ss\\application\\components\\ValueGenerator\\' .
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
        self::COPY_URL,
        self::ARRAY_KEY,
        self::URL,
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
