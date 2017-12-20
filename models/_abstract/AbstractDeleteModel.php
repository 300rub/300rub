<?php

namespace testS\models\_abstract;

use testS\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractDeleteModel extends AbstractSaveModel
{

    /**
     * Deletes model from DB
     *
     * @param string $where
     * @param array  $parameters
     *
     * @throws ModelException
     */
    public final function delete($where = null, array $parameters = [])
    {
        if ($where === null) {
            if (!$this->getId()) {
                throw new ModelException('Unable to delete the record with null ID');
            }

            $this->getDb()->setWhere('id = :id');
            $this->getDb()->addParameter('id', (int)$this->getId());
        } else {
            $this->getDb()->setWhere($where);

            if (count($parameters) > 0) {
                foreach ($parameters as $key => $value) {
                    $this->getDb()->addParameter($key, $value);
                }
            }
        }

        $this->beforeDelete();
        $this->getDb()->delete();
        $this->getDb()->reset();
        $this->afterDelete();
    }

    /**
     * Runs before deleting
     */
    protected function beforeDelete()
    {
    }

    /**
     * Runs after deleting
     */
    protected function afterDelete()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $parameters) {
            if (!array_key_exists(self::FIELD_RELATION, $parameters)) {
                continue;
            }

            $relationModel = $this->getRelationModelByFieldName($field, true);
            $relationModel->delete();
        }
    }
}
