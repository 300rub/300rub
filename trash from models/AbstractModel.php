<?php

//

//

//
//
//

//
//    /**
//     * Adds except ID condition to SQL request
//     *
//     * @param int $id ID
//     *
//     * @return AbstractModel
//     */
//    public function exceptId($id)
//    {
//        $this->getDb()->addWhere(sprintf("%s.id != :id", $this->getTableName()));
//        $this->getDb()->addParameter("id", $id);
//
//        return $this;
//    }
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
//    /**
//     * Models search in DB
//     *
//     * @return null|AbstractModel[]
//     */
//    public function findAll()
//    {
//        $results = $this->setDbRequestDataBeforeFind()->getDb()->findAll();
//        if (!$results) {
//            return [];
//        }
//
//        $list = [];
//        foreach ($results as $result) {
//            /**
//             * @var AbstractModel $model
//             */
//            $model = new $this;
//            $model->setFields($this->_parseDbResponse($result));
//            $model->afterFind();
//            $list[] = $model;
//        }
//
//        return $list;
//    }
//
//    /**
//     * Executes after finding
//     */
//    protected function afterFind()
//    {
//    }
//
//    /**
//     * Parses DB response
//     *
//     * @param array $response
//     *
//     * @return array
//     */
//    private function _parseDbResponse(array $response)
//    {
//        $fields = [];
//
//        foreach ($response as $field => $value) {
//            if (strripos($field, Db::SEPARATOR)) {
//                list($table, $field) = explode(Db::SEPARATOR, $field, 2);
//
//                if (!isset($fields[$table])) {
//                    $fields[$table] = [];
//                }
//                $fields[$table][$field] = $value;
//            } else {
//                $fields[$field] = $value;
//            }
//        }
//
//        return $fields;
//    }
//
//    /**
//     * Deletes model from DB
//     *
//     * @param string $where
//     * @param array  $parameters
//     *
//     * @throws ModelException
//     */
//    public final function delete($where = null, array $parameters = [])
//    {
//        if ($where === null) {
//            if (!$this->id) {
//                throw new ModelException("Unable to delete the record with null ID");
//            }
//
//            $this->getDb()->setWhere("id = :id");
//            $this->getDb()->setParameters(["id" => $this->id]);
//        } else {
//            $this->getDb()->setWhere($where);
//
//            if (count($parameters) > 0) {
//                $this->getDb()->setParameters($parameters);
//            }
//        }
//
//        $this->beforeDelete();
//        $this->getDb()->delete();
//        $this->afterDelete();
//    }
//
//    /**
//     * Runs before deleting
//     */
//    protected function beforeDelete()
//    {
//    }
//
//    /**
//     * Runs after deleting
//     */
//    protected function afterDelete()
//    {
//        foreach ($this->getFieldsInfo() as $field => $parameters) {
//            if (!array_key_exists(self::FIELD_RELATION, $parameters)) {
//                continue;
//            }
//
//            $relationModel = $parameters[self::FIELD_RELATION];
//            $relationName = substr($field, 0, -2) . "Model";
//            $relationModelName = "\\testS\\models\\" . $relationModel;
//
//            /**
//             * @var AbstractModel $relationModel
//             */
//            if (!$this->$relationName instanceof $relationModelName
//                || !$this->$relationName->id
//            ) {
//                $relationModel = new $relationModelName;
//                $relationModel = $relationModel->byId($this->$field)->find();
//            } else {
//                $relationModel = $this->$relationName;
//            }
//
//            $relationModel->delete();
//        }
//    }
//

//

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

