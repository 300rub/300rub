<?php

namespace ss\application\components\valueGenerator\_abstract;

/**
 * Class for generation values
 */
abstract class AbstractGenerator
{

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
     * Sets value
     *
     * @param mixed $value Value
     *
     * @return AbstractGenerator
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Sets parameter
     *
     * @param mixed $param Parameter
     *
     * @return AbstractGenerator
     */
    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }
}
