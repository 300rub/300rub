<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractFilter;

/**
 * Class for color value generation
 */
class Color extends AbstractFilter
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
