<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for max value generation
 */
class Max extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        if (is_array($this->param) === true) {
            $operator = '-';
            if (empty($this->param[2]) === false) {
                $operator = $this->param[2];
            }

            $this->param = $this->getValueByOperator(
                $this->param[0],
                $this->param[1],
                $operator,
                99999
            );
        }

        if ($this->value > $this->param) {
            $this->value = $this->param;
        }

        return $this->value;
    }
}
