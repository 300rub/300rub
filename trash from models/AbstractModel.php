<?php

//
//    /**
//     * Adds in condition to SQL request
//     *
//     * @param string $field  Field name
//     * @param array  $values Values
//     *
//     * @return AbstractModel
//     */
//    public function in($field, $values)
//    {
//        $this->getDb()->addWhere(
//            sprintf(
//                "%s IN (%s)",
//                $field,
//                implode(",", $values)
//            )
//        );
//
//        return $this;
//    }
//
//    /**
//     * Adds ORDER BY to SQL request
//     *
//     * @param string $value
//     *
//     * @return AbstractModel
//     */
//    public function ordered($value = "name")
//    {
//        $this->getDb()->setOrder($value);
//        return $this;
//    }
//
//
//
//
//    /**
//     * Duplicates the model
//     *
//     * @return AbstractModel
//     */
//    public function duplicate()
//    {
//        /**
//         * @var AbstractModel $duplicateModel
//         */
//        $duplicateModel = new $this;
//
//        foreach ($this->getFieldsInfo() as $field => $info) {
//            if (array_key_exists(self::FIELD_RELATION, $info)) {
//                $relationName = substr($field, 0, -2) . "Model";
//                $duplicateRelationModel = $this->$relationName->duplicate();
//                $duplicateModel->$relationName = $duplicateRelationModel;
//                $duplicateModel->$field = $duplicateRelationModel->id;
//                continue;
//            }
//
//            if (array_key_exists(self::FIELD_SKIP_DUPLICATION, $info)) {
//                $duplicateModel->$field = null;
//                continue;
//            }
//
//            $duplicateModel->$field = $this->$field;
//
//            if (array_key_exists(self::FIELD_CHANGE_ON_DUPLICATE, $info)) {
//                $duplicateModel->$field = $this->_generateFieldValue(
//                    $duplicateModel->$field,
//                    $info[self::FIELD_CHANGE_ON_DUPLICATE]
//                );
//            }
//        }
//
//        $duplicateModel->save();
//
//        return $duplicateModel;
//    }
//