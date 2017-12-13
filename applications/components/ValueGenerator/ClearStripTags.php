<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for generation of value with clear strip tags
 */
class ClearStripTags extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $param Param
     *
     * @return mixed
     */
    public function generate($value, $param)
    {
        ValueGenerator::factory('aaa', 'bbbb')->generate('aaaa', 'bbb');

        return trim(
            strip_tags(
                preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $value)
            )
        );
    }
}
