<?php

namespace testS\models;

/**
 * Abstract class for working with design models
 *
 * @package testS\models
 */
abstract class AbstractDesignModel extends AbstractModel 
{

    /**
     * Values
     *
     * @var array
     */
    protected $designValues = [];

    /**
     * Values availability
     *
     * @var array
     */
    protected $designValuesAvailability = [];

    /**
     * Executes after finding
     */
    protected function afterFind()
    {
        $this->setDefaultValuesAvailability();
        
        parent::afterFind();
    }

    /**
     * Sets default values availability
     *
     * @return AbstractDesignModel
     */
    protected function setDefaultValuesAvailability()
    {
        foreach (array_keys($this->getFieldsInfo()) as $field) {
            $this->designValuesAvailability[$field] = true;
        }

        return $this;
    }
    
    /**
     * Excepts values
     *
     * @param array $values
     *
     * @return AbstractDesignModel
     */
    public function exceptValues(array $values)
    {
        foreach ($values as $value) {
            if (array_key_exists($value, $this->designValuesAvailability)) {
                $this->designValuesAvailability[$value] = false;
            }
        }

        return $this;
    }

    /**
     * Sets value
     *
     * @param string $group
     * @param string $type
     * @param string $field
     * @param string $name
     *
     * @return AbstractDesignModel
     */
    protected function setDesignValue($group, $type, $field, $name)
    {
        if (!array_key_exists($field, $this->designValuesAvailability)) {
            return $this;
        }

        if (!property_exists($this, $field)) {
            return $this;
        }

        if ($this->designValuesAvailability[$field] === false) {
            return $this;
        }

        if (!array_key_exists($group, $this->designValues)) {
            $this->designValues[$group] = [];
        }

        if (!array_key_exists($type, $this->designValues[$group])) {
            $this->designValues[$group][$type] = [];
        }

        $this->designValues[$group][$type][$field] = [
            "name"  => sprintf($name, $field),
            "value" => $this->$field
        ];

        return $this;
    }
}