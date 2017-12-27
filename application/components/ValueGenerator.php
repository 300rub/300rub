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
    const ARRAY_KEY = 'ArrayKey';
    const BOOL_INT = 'BoolIntValue';
    const BOOL = 'BoolValue';
    const CLEAR_STRIP_TAGS = 'ClearStripTags';
    const COLOR = 'Color';
    const COPY_NAME = 'CopyName';
    const DATETIME = 'DateTimeValue';
    const FLOAT = 'FloatValue';
    const INT = 'IntValue';
    const MAX = 'Max';
    const MIN = 'Min';
    const MIN_THEN = 'MinThen';
    const STRING = 'StringValue';
    const URL = 'Url';
    const COPY_URL = 'UrlCopy';
    const DATETIME_AS_STRING = 'Iso';
    const ORDERED_ARRAY = 'OrderedArrayForJson';

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

        $className
            = "\\testS\\application\\components\\ValueGenerator\\" . $type;
        $object = new $className;
        $object->value = $value;
        $object->param = $param;

        return $object;
    }
}
