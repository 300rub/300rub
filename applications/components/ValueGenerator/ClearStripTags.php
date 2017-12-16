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
     * @return mixed
     */
    public function generate()
    {
        return trim(
            strip_tags(
                preg_replace(
                    '/<script\b[^>]*>(.*?)<\/script>/is',
                    '',
                    $this->value
                )
            )
        );
    }
}
