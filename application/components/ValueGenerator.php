<?php

namespace testS\application\components;

use testS\application\exceptions\CommonException;

/**
 * Class for generation values
 */
abstract class ValueGenerator
{

    /**
     * Types
     */
    const ARRAY_KEY
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'filter\\ArrayKey';
    const BOOL_INT
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\BoolIntValue';
    const BOOL
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\BoolValue';
    const CLEAR_STRIP_TAGS
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'modify\\ClearStripTags';
    const COLOR
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'filter\\Color';
    const COPY_NAME
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'modify\\CopyName';
    const DATETIME
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\DateTimeValue';
    const FLOAT
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\FloatValue';
    const INT
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\IntValue';
    const MAX
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'math\\Max';
    const MIN
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'math\\Min';
    const MIN_THEN
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'math\\MinThen';
    const STRING
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\StringValue';
    const URL
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'modify\\Url';
    const COPY_URL
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'modify\\UrlCopy';
    const DATETIME_AS_STRING
        = '\\testS\\application\\components\\ValueGenerator\\' .
            'type\\Iso';
    const ORDERED_ARRAY
        = '\\testS\\application\\components\\ValueGenerator\\' .
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
