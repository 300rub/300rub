<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for color value generation
 */
class Color extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        $isValid = preg_match(
            '/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*' .
            '(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i',
            $this->value
        );

        if ($isValid === true) {
            return $this->value;
        }

        return '';
    }
}
