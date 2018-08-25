<?php

namespace ss\models\_abstract;

use ss\application\components\db\Table;
use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractFindModel extends AbstractBaseModel
{

    /**
     * Default order name
     */
    const DEFAULT_ORDER_NAME = 'name';

    /**
     * Array of relation names to select
     *
     * @var string[]
     */
    private $_withRelations = [];

    /**
     * Adds ID condition to SQL request
     *
     * @param int $idValue ID
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function byId($idValue)
    {
        $this->getTable()
            ->addWhere(sprintf('%s.id = :id', Table::DEFAULT_ALIAS))
            ->addParameter('id', (int)$idValue);

        return $this;
    }

    /**
     * Adds except ID condition to SQL request
     *
     * @param int $idValue ID
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function exceptId($idValue)
    {
        $this->getTable()
            ->addWhere(sprintf('%s.id != :id', Table::DEFAULT_ALIAS))
            ->addParameter('id', (int)$idValue);

        return $this;
    }

    /**
     * With all relations
     *
     * @param string[] $withRelations Relations
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function withRelations(array $withRelations)
    {
        $this->_withRelations = $withRelations;
        return $this;
    }

    /**
     * Adds condition to select latest model
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function latest()
    {
        $this->getTable()->setOrder(
            sprintf('%s.id DESC', Table::DEFAULT_ALIAS)
        );
        return $this;
    }

    /**
     * Adds ORDER BY to SQL request
     *
     * @param string|array $value  Order by value
     * @param string       $alias  Table alias
     * @param bool         $isDesc Flag of order indirection
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function ordered(
        $value = self::DEFAULT_ORDER_NAME,
        $alias = Table::DEFAULT_ALIAS,
        $isDesc = null
    ) {
        $order = 'ASC';
        if ($isDesc === true) {
            $order = 'DESC';
        }

        $orderBy = null;

        if (is_array($value) === false) {
            $orderBy = sprintf('%s.%s', $alias, $value);
        }

        if (is_array($value) === true) {
            $list = [];
            foreach ($value as $v) {
                $list[] = sprintf('%s.%s', $alias, $v);
            }

            $orderBy = implode(',', $list);
        }

        $this->getTable()->setOrder(sprintf('%s %s', $orderBy, $order));

        return $this;
    }

    /**
     * Adds in condition to SQL request
     *
     * @param string $field  Table field
     * @param array  $values Values
     * @param string $alias  Table alias
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function addIn(
        $field,
        array $values,
        $alias = Table::DEFAULT_ALIAS
    ) {
        foreach ($values as &$value) {
            if (is_string($value) === true) {
                $value = sprintf('\'%s\'', $value);
            }
        }

        $this->getTable()->addWhere(
            sprintf(
                '%s.%s IN (%s)',
                $alias,
                $field,
                implode(',', $values)
            )
        );

        return $this;
    }

    /**
     * Gets relation model
     *
     * @param string $fieldName Field name
     * @param bool   $isFind    Flag of finding a model by field - ID
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    protected function getRelationModelByFieldName($fieldName, $isFind = null)
    {
        $info = $this->getFieldsInfo();

        if (array_key_exists($fieldName, $info) === false) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$fieldName]
            );

            if ($hasRelation === false) {
                return null;
            }
        }

        $relationField = $this->getRelationName($fieldName);
        $relationModelName = $info[$fieldName][self::FIELD_RELATION];

        $field = $this->getField($relationField);
        if ($field instanceof $relationModelName) {
            return $field;
        }

        $model = $this->getModelByName($relationModelName);

        if ($isFind !== true) {
            return $model;
        }

        $idValue = $this->getField($fieldName);
        if ($idValue === 0) {
            return $model;
        }

        $model = $model->byId($idValue)->find();
        if ($model !== null) {
            $this->setField($relationField, $model);
            return $model;
        }

        throw new ModelException(
            'Unable to find model: {model} by ID: {id}',
            [
                'model' => $relationModelName,
                'id'    => $idValue
            ]
        );
    }

    /**
     * Model search in DB
     *
     * @param bool $isReturnArray Flag to return array
     *
     * @return AbstractModel|null
     */
    public function find($isReturnArray = null)
    {
        $table = $this->setTableBeforeFind()->getTable();
        $result = $table->find();

        if ($result === false) {
            return null;
        }

        if ($isReturnArray === true) {
            return $result;
        }

        $model = $this->getNewModel();
        $model->set($this->_parseTableResponse($result));
        $model->afterFind();

        $this->resetTable();

        return $model;
    }

    /**
     * Models search in DB
     *
     * @param bool $isReturnArray Flag to return array
     *
     * @return null|AbstractModel[]
     */
    public function findAll($isReturnArray = null)
    {
        $table = $this->setTableBeforeFind()->getTable();
        $results = $table->findAll();

        if (count($results) === 0) {
            return [];
        }

        if ($isReturnArray === true) {
            return $results;
        }

        $list = [];
        foreach ($results as $result) {
            $model = $this->getNewModel();
            $model->set($this->_parseTableResponse($result));
            $model->afterFind();
            $list[] = $model;
        }

        $this->resetTable();

        return $list;
    }

    /**
     * Parses DB response
     *
     * @param array $response DB Response
     *
     * @return array
     */
    private function _parseTableResponse($response)
    {
        if (is_array($response) === false) {
            return [];
        }

        $helpList = [];
        $list = [];

        foreach ($response as $fullFieldName => $value) {
            if (strpos($fullFieldName, Table::SEPARATOR) === false) {
                $list[$fullFieldName] = $value;
                continue;
            }

            list($alias, $field)
                = explode(Table::SEPARATOR, $fullFieldName, 2);
            if (array_key_exists($alias, $helpList) === false) {
                $helpList[$alias] = [];
            }

            $helpList[$alias][$field] = $value;
        }

        foreach ($helpList as $key => $response) {
            if ($key === Table::DEFAULT_ALIAS) {
                foreach ($response as $k => $value) {
                    $list[$k] = $value;
                }

                continue;
            }

            $list[$key] = $this->_parseTableResponse($response);
        }

        return $list;
    }

    /**
     * Sets DB before find
     *
     * @param string $alias DB table alias
     *
     * @return AbstractModel|AbstractFindModel
     */
    public final function setTableBeforeFind($alias = Table::DEFAULT_ALIAS)
    {
        $info = $this->getFieldsInfo();
        $table = $this->getTable();

        $table->addSelect(self::PK_FIELD, $alias);

        foreach (array_keys($info) as $field) {
            $table->addSelect($field, $alias);

            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$field]
            );

            if ($hasRelation === false
                || count($this->_withRelations) === 0
            ) {
                continue;
            }

            $relationName = $this->getRelationName($field);
            if (in_array($relationName, $this->_withRelations) === false
                && $this->_withRelations[0] !== '*'
            ) {
                continue;
            }

            $relationModel = $this->getRelationModelByFieldName($field);
            if ($relationModel instanceof AbstractModel === false) {
                continue;
            }

            $relationField = $this->getRelationName($field);

            $relationAlias = $alias . Table::SEPARATOR . $relationField;
            if ($alias === Table::DEFAULT_ALIAS) {
                $relationAlias = $relationField;
            }

            if ($this->_withRelations[0] === '*') {
                $relationModel->withRelations($this->_withRelations);
            }

            $relationModel->setTable($table);

            $table->addJoin(
                Table::JOIN_TYPE_INNER,
                $relationModel->getTableName(),
                $relationAlias,
                self::PK_FIELD,
                $alias,
                $field
            );

            $relationModel->setTableBeforeFind($relationAlias);
        }

        return $this;
    }

    /**
     * Count of records
     *
     * @return int
     */
    public function getCount()
    {
        return count(
            $this->setTableBeforeFind()->getTable()->findAll()
        );
    }

    /**
     * Executes after finding
     *
     * @return void
     */
    protected function afterFind()
    {
    }

    /**
     * Adds condition to check unique value
     *
     * @param string $field Field
     *
     * @return AbstractModel|AbstractSaveModel
     */
    protected function checkUnique($field)
    {
        $this->getTable()
            ->addWhere(
                sprintf(
                    '%s.%s = :field',
                    Table::DEFAULT_ALIAS,
                    $field
                )
            )
            ->addParameter(
                'field',
                $this->getField($field)
            );

        return $this;
    }
}
