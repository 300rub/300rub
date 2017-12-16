<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for ordered key value array for json generation
 */
class OrderedArrayForJson extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        asort($this->value);
        $list = [];

        foreach ($this->value as $key => $value) {
            $list[] = [
                'key'   => $key,
                'value' => $value
            ];
        }

        return $list;
    }
}
