<?php

namespace ss\application\components\valueGenerator\filter;

use ss\application\components\valueGenerator\_abstract\AbstractFilter;
use ss\application\exceptions\ContentException;

/**
 * Class for array key generation
 */
class ArrayKey extends AbstractFilter
{

    /**
     * Generates value
     *
     * @return mixed
     *
     * @throws ContentException
     */
    public function generate()
    {
        $list = $this->param[0];
        $defaultValue = null;

        if (array_key_exists(1, $this->param) === true) {
            $defaultValue = $this->param[1];
        }

        if (array_key_exists($this->value, $list) === true) {
            return $this->value;
        }

        if (array_key_exists($defaultValue, $list) === true) {
            return $defaultValue;
        }

        throw new ContentException(
            'Unable to find value: {value} from array keys: {keys}',
            [
                'value' => $this->value,
                'keys'  => implode(', ', array_keys($list))
            ]
        );
    }
}
