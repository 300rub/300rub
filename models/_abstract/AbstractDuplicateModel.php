<?php

namespace testS\models\_abstract;

use testS\application\components\ValueGenerator;

/**
 * Abstract class for working with models
 */
abstract class AbstractDuplicateModel extends AbstractDeleteModel
{

    /**
     * Duplicates the model
     *
     * @return AbstractModel
     */
    public function duplicate()
    {
        $duplicateModel = new $this;

        foreach ($this->getFieldsInfo() as $field => $info) {
            if (array_key_exists(self::FIELD_SKIP_DUPLICATION, $info)) {
                if (array_key_exists(self::FIELD_RELATION, $info)
                    || array_key_exists(self::FIELD_RELATION_TO_PARENT, $info)
                ) {
                    $duplicateModel->setField($field, null);
                } else {
                    $duplicateModel->set([$field => null]);
                }

                continue;
            }

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationName = $this->getRelationName($field);
                $relationModel = $this->getRelationModelByFieldName($field, true);
                if (!$relationModel instanceof AbstractModel) {
                    continue;
                }

                $duplicateRelationModel = $relationModel->duplicate();

                $duplicateModel->setField($relationName, $duplicateRelationModel);
                $duplicateModel->setField($field, $duplicateRelationModel->getId());
                continue;
            }

            $duplicateModel->setField($field, $this->get($field));

            if (array_key_exists(self::FIELD_BEFORE_DUPLICATE, $info)) {
                foreach ($info[self::FIELD_BEFORE_DUPLICATE] as $key => $value) {
                    if (is_string($key)) {
                        $method = $key;
                        if (method_exists($this, $method)) {
                            $duplicateModel->set(
                                [
                                    $field => $duplicateModel->$method($duplicateModel->get($field), $value)
                                ]
                            );
                        }
                    } else {
                        $method = $value;
                        if (method_exists($this, $method)) {
                            $duplicateModel->set(
                                [
                                    $field => $duplicateModel->$method($duplicateModel->get($field))
                                ]
                            );
                        }
                    }
                }
            }

            if (!array_key_exists(self::FIELD_CHANGE_ON_DUPLICATE, $info)) {
                continue;
            }

            foreach ($info[self::FIELD_CHANGE_ON_DUPLICATE] as $valueGeneratorKey => $valueGeneratorValue) {
                if (!is_string($valueGeneratorKey)) {
                    $duplicateModel->setField(
                        $field,
                        ValueGenerator::factory(
                            $valueGeneratorValue,
                            $duplicateModel->get($field)
                        )->generate()
                    );
                    continue;
                }

                if (is_string($valueGeneratorValue)
                    && stripos($valueGeneratorValue, '{') === 0
                ) {
                    $valueGeneratorValue = $duplicateModel->get(
                        str_replace(['{', '}'], '', $valueGeneratorValue)
                    );
                } elseif (is_array($valueGeneratorValue)) {
                    foreach ($valueGeneratorValue as &$valueGeneratorVal) {
                        if (is_string($valueGeneratorVal)
                            && stripos($valueGeneratorVal, '{') === 0
                        ) {
                            $valueGeneratorVal = $duplicateModel->get(
                                str_replace(['{', '}'], '', $valueGeneratorVal)
                            );
                        }
                    }
                }

                $duplicateModel->setField(
                    $field,
                    ValueGenerator::factory(
                        $valueGeneratorKey,
                        $duplicateModel->get($field),
                        $valueGeneratorValue
                    )->generate()
                );
            }
        }

        $duplicateModel->save();
        $duplicateModel->afterDuplicate($this);

        return $duplicateModel;
    }

    /**
     * After duplicate
     *
     * @param AbstractBaseModel $oldModel
     */
    protected function afterDuplicate($oldModel)
    {
    }
}
