<?php

namespace ss\models\_abstract;

use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractDeleteModel extends AbstractSaveModel
{

    /**
     * Deletes model from DB
     *
     * @param string $where      Where condition
     * @param array  $parameters Parameters
     *
     * @return void
     */
    public final function delete($where = null, array $parameters = [])
    {
        $this->_setDeleteCondition($where, $parameters);

        $this->beforeDelete();
        $this->getTable()->delete();
        $this->afterDelete();

        $this->resetTable();
    }

    /**
     * Sets delete condition
     *
     * @param string $where      Where condition
     * @param array  $parameters Parameters
     *
     * @return AbstractDeleteModel
     *
     * @throws ModelException
     */
    private function _setDeleteCondition($where, array $parameters)
    {
        if ($where === null) {
            if ($this->getId() === 0) {
                throw new ModelException(
                    'Unable to delete the record with null ID'
                );
            }

            $this->getTable()->setWhere('id = :id');
            $this->getTable()->addParameter('id', (int)$this->getId());

            return $this;
        }

        $this->getTable()->setWhere($where);

        if (count($parameters) > 0) {
            foreach ($parameters as $key => $value) {
                $this->getTable()->addParameter($key, $value);
            }
        }

        return $this;
    }

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
    }

    /**
     * Runs after deleting
     *
     * @return void
     */
    protected function afterDelete()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $parameters) {
            if (array_key_exists(self::FIELD_RELATION, $parameters) === false
                || array_key_exists(self::FIELD_SKIP_REMOVAL, $parameters) === true
            ) {
                continue;
            }

            $relationModel = $this->getRelationModelByFieldName($field, true);
            $relationModel->delete();
        }

        $this->afterChange();
    }
}
