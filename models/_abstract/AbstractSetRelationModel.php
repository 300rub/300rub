<?php

namespace ss\models\_abstract;

use ss\application\components\ValueGenerator;

/**
 * Abstract class for working with models
 */
abstract class AbstractSetRelationModel extends AbstractFindModel
{

    /**
     * Sets relations
     *
     * @param array $fields Fields
     *
     * @return AbstractSetFieldModel|AbstractSetRelationModel
     */
    protected function setRelations(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            $relationIdField = $this->getRelationIdFields($field);
            if (array_key_exists($field, $this->getFields()) === false) {
                continue;
            }

            if ($value instanceof self === false
                && is_array($value) === false
            ) {
                continue;
            }

            if (array_key_exists($relationIdField, $info) === false) {
                continue;
            }

            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$relationIdField]
            );
            if ($hasRelation === false) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$relationIdField]
            );
            if ($hasNotChange === true) {
                continue;
            }

            $this->_setRelation($field, $value, $relationIdField);
        }

        $this->_setRelationId($fields);

        return $this;
    }

    /**
     * Sets relations to parent
     *
     * @param array $fields Fields
     *
     * @return AbstractSetFieldModel|AbstractSetRelationModel
     */
    protected function setRelationsToParent(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (array_key_exists($field, $info) === false) {
                continue;
            }

            $hasRelation = array_key_exists(
                self::FIELD_RELATION_TO_PARENT,
                $info[$field]
            );

            if (array_key_exists($field, $this->getFields()) === false
                || array_key_exists($field, $info) === false
                || $hasRelation === false
            ) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$field]
            );
            if ($this->isNew() === false
                && $hasNotChange === true
            ) {
                continue;
            }

            $this->setField(
                $field,
                ValueGenerator::factory(ValueGenerator::INT, $value)->generate()
            );
        }

        return $this;
    }

    /**
     * Sets relation
     *
     * @param string                  $field           Field
     * @param AbstractBaseModel|array $value           Value
     * @param int                     $relationIdField ID
     *
     * @return void
     */
    private function _setRelation($field, $value, $relationIdField)
    {
        $relationModel = $value;
        if ($relationModel instanceof self === false) {
            $isFind = true;
            if ($this->isNew() === true) {
                $isFind = false;
            }

            $relationModel = $this->getRelationModelByFieldName(
                $relationIdField,
                $isFind
            );
            $relationModel->set($value);
        }

        $this->setField($field, $relationModel);

        if ($relationModel->getId() > 0) {
            $this->setField($relationIdField, $relationModel->getId());
        }
    }

    /**
     * Sets relation ID
     *
     * @param array $fields Fields
     *
     * @return void
     */
    private function _setRelationId(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (array_key_exists($field, $info) === false) {
                continue;
            }

            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$field]
            );
            if (array_key_exists($field, $info) === false
                || $hasRelation === false
                || (int)$value === 0
            ) {
                continue;
            }

            $this->setField($field, (int)$value);
        }
    }
}
