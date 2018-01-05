<?php

namespace testS\models\_abstract;

use testS\application\components\ValueGenerator;

/**
 * Abstract class for working with models
 */
abstract class AbstractDuplicateModel extends AbstractDeleteModel
{

    /**
     * Duplicate model
     *
     * @var AbstractModel
     */
    private $_duplicateModel = null;

    /**
     * Duplicate ID
     *
     * @var integer
     */
    private $_duplicateId = 0;

    /**
     * Duplicates the model
     *
     * @return AbstractModel
     */
    public function duplicate()
    {
        $this->_duplicateModel = $this->getNewModel();

        foreach ($this->getFieldsInfo() as $field => $info) {
            $hasSkipDuplication = array_key_exists(
                self::FIELD_SKIP_DUPLICATION,
                $info
            );
            if ($hasSkipDuplication === true) {
                continue;
            }

            if (array_key_exists(self::FIELD_RELATION, $info) === true) {
                $this->_setRelation($field);
                continue;
            }

            $this
                ->_setDuplicationField($field)
                ->_setBeforeDuplicate($info, $field)
                ->_setChangeOnDuplicate($info, $field);
        }

        $newModel = $this->_duplicateModel->save();
        $newModel
            ->setDuplicateId($this->getId())
            ->afterDuplicate();

        return $newModel;
    }

    /**
     * Sets field
     *
     * @param string $field Field
     *
     * @return AbstractDuplicateModel
     */
    private function _setDuplicationField($field)
    {
        $this->_duplicateModel->setField($field, $this->get($field));
        return $this;
    }

    /**
     * Sets relation
     *
     * @param string $field Field
     *
     * @return AbstractDuplicateModel
     */
    private function _setRelation($field)
    {
        $relationModel = $this->getRelationModelByFieldName(
            $field,
            true
        );
        if ($relationModel instanceof AbstractModel === false) {
            return $this;
        }

        $newRelationModel = $relationModel->duplicate();

        $this->_duplicateModel
            ->setField(
                $this->getRelationName($field),
                $newRelationModel
            )
            ->setField(
                $field,
                $newRelationModel->getId()
            );

        return $this;
    }

    /**
     * Before duplicate
     *
     * @param array  $info  Fields info
     * @param string $field Field
     *
     * @return AbstractDuplicateModel
     */
    private function _setBeforeDuplicate($info, $field)
    {
        $hasBeforeDuplicate = array_key_exists(
            self::FIELD_BEFORE_DUPLICATE,
            $info
        );
        if ($hasBeforeDuplicate === false) {
            return $this;
        }

        $beforeDuplicate = $info[self::FIELD_BEFORE_DUPLICATE];
        if ($hasBeforeDuplicate === false) {
            return $this;
        }

        foreach ($beforeDuplicate as $key => $value) {
            if (is_string($key) === true) {
                $method = $key;
                if (method_exists($this, $method) === false) {
                    continue;
                }

                $this->_duplicateModel->set(
                    [
                        $field => $this->_duplicateModel->$method(
                            $this->_duplicateModel->get($field),
                            $value
                        )
                    ]
                );

                continue;
            }

            $method = $value;
            if (method_exists($this, $method) === false) {
                continue;
            }

            $this->_duplicateModel->set(
                [
                    $field => $this->_duplicateModel->$method(
                        $this->_duplicateModel->get($field)
                    )
                ]
            );
        }

        return $this;
    }

    /**
     * Changes on duplication
     *
     * @param array  $info  Fields info
     * @param string $field Field
     *
     * @return AbstractDuplicateModel
     */
    private function _setChangeOnDuplicate($info, $field)
    {
        $hasChangeOnDuplicate = array_key_exists(
            self::FIELD_CHANGE_ON_DUPLICATE,
            $info
        );
        if ($hasChangeOnDuplicate === false) {
            return $this;
        }

        foreach ($info[self::FIELD_CHANGE_ON_DUPLICATE] as $key => $value) {
            $this->_setChangeOnDuplicateField($field, $key, $value);
        }

        return $this;
    }

    /**
     * Changes field on duplication
     *
     * @param string         $field Field
     * @param integer|string $key   Key
     * @param string|array   $value Value
     *
     * @return AbstractDuplicateModel
     */
    private function _setChangeOnDuplicateField($field, $key, $value)
    {
        if (is_string($key) === false) {
            $this->_duplicateModel->setField(
                $field,
                ValueGenerator::factory(
                    $value,
                    $this->_duplicateModel->get($field)
                )->generate()
            );

            return $this;
        }

        if (is_string($value) === true
            && stripos($value, '{') === 0
        ) {
            $value = $this->_duplicateModel->get(
                str_replace(['{', '}'], '', $value)
            );
        } elseif (is_array($value) === true) {
            foreach ($value as &$valueGeneratorVal) {
                if (is_string($valueGeneratorVal) === true
                    && stripos($valueGeneratorVal, '{') === 0
                ) {
                    $valueGeneratorVal = $this->_duplicateModel->get(
                        str_replace(['{', '}'], '', $valueGeneratorVal)
                    );
                }
            }
        }

        $this->_duplicateModel->setField(
            $field,
            ValueGenerator::factory(
                $key,
                $this->_duplicateModel->get($field),
                $value
            )->generate()
        );

        return $this;
    }

    /**
     * Sets Duplicate ID
     *
     * @param int $duplicateId Duplicate ID
     *
     * @return AbstractDuplicateModel
     */
    public function setDuplicateId($duplicateId)
    {
        $this->_duplicateId = $duplicateId;
        return $this;
    }

    /**
     * Gets duplicate ID
     *
     * @return int
     */
    protected function getDuplicateId()
    {
        return $this->_duplicateId;
    }

    /**
     * After duplicate
     *
     * @return void
     */
    protected function afterDuplicate()
    {
    }
}
