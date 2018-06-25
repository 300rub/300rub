<?php

namespace ss\models\_abstract;

use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractSaveRelationModel extends AbstractValidateModel
{

    /**
     * Sets relation fields before save
     *
     * @return AbstractModel|AbstractSaveModel
     *
     * @throws ModelException
     */
    protected function setRelationsBeforeSave()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $relationInfo) {
            if ($this->_isRelation($field, $relationInfo) === false) {
                continue;
            }

            $relationName = $this->getRelationName($field);
            $modelName = $relationInfo[self::FIELD_RELATION];

            $relationModel = $this->get($relationName);
            if ($relationModel instanceof $modelName === false) {
                $relationModel = $this->getModelByName($modelName);

                if ($this->get($field) !== 0) {
                    $relationModel = $relationModel
                        ->byId($this->get($field))
                        ->find();

                    if ($relationModel instanceof $modelName === false) {
                        throw new ModelException(
                            'Unable to find relation with name: ' .
                            '{name} by id: {id}',
                            [
                                'name' => $relationName,
                                'id'   => $this->get($field)
                            ]
                        );
                    }
                }
            }

            $relationModel->save();
            if (count($relationModel->getErrors()) > 0) {
                $this->addErrors($relationName, $relationModel->getErrors());
            }

            $this->setField($field, $relationModel->getId());
            $this->setField($relationName, $relationModel);
        }

        return $this;
    }

    /**
     * Is relation
     *
     * @param string $field        Field
     * @param array  $relationInfo Relation info
     *
     * @return bool
     */
    private function _isRelation($field, $relationInfo)
    {
        $hasRelation = array_key_exists(
            self::FIELD_RELATION,
            $relationInfo
        );
        if ($hasRelation === false) {
            return false;
        }

        $isAllowNull = array_key_exists(
            self::FIELD_ALLOW_NULL,
            $relationInfo
        );
        if ($isAllowNull === true
            && $this->getField($field) === null
            && $this->getField($this->getRelationName($field)) === null
        ) {
            return false;
        }

        return true;
    }

    /**
     * Checks parents before save
     *
     * @throws ModelException
     *
     * @return AbstractModel|AbstractSaveModel
     */
    protected function checkParentsBeforeSave()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION_TO_PARENT,
                $fieldInfo
            );
            if ($hasRelation === false) {
                continue;
            }

            $value = $this->getField($field);

            $isAllowNull = array_key_exists(
                self::FIELD_ALLOW_NULL,
                $fieldInfo
            );
            if ($isAllowNull === true
                && $value === null
            ) {
                continue;
            }

            if ($value === 0) {
                throw new ModelException(
                    'Unable to save {className} because {field} is 0',
                    [
                        'className' => get_class($this),
                        'field'     => $field
                    ]
                );
            }

            $modelName = $fieldInfo[self::FIELD_RELATION_TO_PARENT];
            $model = $this->getModelByName($modelName);
            if ($model instanceof AbstractModel === false) {
                $model = $model->byId($value)->find();
                if ($model instanceof AbstractModel === false) {
                    throw new ModelException(
                        'Unable to find model: {model} with ID = {id}',
                        [
                            'model' => $modelName,
                            'id'    => $value
                        ]
                    );
                }
            }
        }

        return $this;
    }
}
