<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractFilter;
use testS\application\exceptions\CommonException;

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
     * @throws CommonException
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

        throw new CommonException(
            'Unable to find value: {value} from array keys: {keys}',
            [
                'value' => $this->value,
                'keys'  => implode(', ', array_keys($list))
            ]
        );
    }
}
