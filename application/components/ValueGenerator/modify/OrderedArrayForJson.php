<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractModifier;

/**
 * Class for ordered key value array for json generation
 */
class OrderedArrayForJson extends AbstractModifier
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