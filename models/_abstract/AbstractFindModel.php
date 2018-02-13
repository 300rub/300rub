<?php

namespace ss\models\_abstract;

use ss\application\components\Db;
use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractFindModel extends AbstractGetModel
{

    /**
     * Default order name
     */
    const DEFAULT_ORDER_NAME = 'name';

    /**
     * Flag of selecting relations
     *
     * @var string[]
     */
    private $_withRelations = false;

    /**
     * Relations to except
     *
     * @var array
     */
    private $_exceptRelations = [];

    /**
     * Adds ID condition to SQL request
     *
     * @param int $idValue ID
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function byId($idValue)
    {
        $this->getDb()->addWhere(sprintf('%s.id = :id', Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter('id', (int)$idValue);

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
        $this->getDb()->addWhere(sprintf('%s.id != :id', Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter('id', (int)$idValue);

        return $this;
    }

    /**
     * With all relations
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function withRelations()
    {
        $this->_withRelations = true;
        return $this;
    }

    /**
     * Without all relations
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function withoutRelations()
    {
        $this->_withRelations = false;
        return $this;
    }

    /**
     * Except relations
     *
     * @param string[] $aliases Relation aliases
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function exceptRelations(array $aliases)
    {
        $this->_exceptRelations = $aliases;
        return $this;
    }

    /**
     * Adds condition to select latest model
     *
     * @return AbstractModel|AbstractFindModel
     */
    public function latest()
    {
        $this->getDb()->setOrder(sprintf('%s.id DESC', Db::DEFAULT_ALIAS));
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
        $alias = Db::DEFAULT_ALIAS,
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

        $this->getDb()->setOrder(sprintf('%s %s', $orderBy, $order));

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
    public function addIn($field, $values, $alias = Db::DEFAULT_ALIAS)
    {
        $this->getDb()->addWhere(
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

        $hasRelation = array_key_exists(
            self::FIELD_RELATION,
            $info[$fieldName]
        );
        if (array_key_exists($fieldName, $info) === false
            || $hasRelation === false
        ) {
            return null;
        }

        $relationField = $this->getRelationName($fieldName);
        $relationModelName = $info[$fieldName][self::FIELD_RELATION];
        if ($this->get($relationField) instanceof $relationModelName) {
            return $this->get($relationField);
        }

        $model = $this->getModelByName($relationModelName);

        if ($isFind !== true) {
            return $model;
        }

        $idValue = $this->get($fieldName);
        if ($idValue === 0) {
            return $model;
        }

        $model = $model->byId($idValue)->find();
        if ($model !== null) {
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
     * @return AbstractModel|null
     */
    public function find()
    {
        $result = $this->setDbBeforeFind()->getDb()->find();
        $this->getDb()->reset();

        if ($result === false) {
            return null;
        }

        $model = $this->getNewModel();
        $model->set($this->_parseDbResponse($result));
        $model->afterFind();

        return $model;
    }

    /**
     * Models search in DB
     *
     * @return null|AbstractModel[]
     */
    public function findAll()
    {
        $results = $this->setDbBeforeFind()->getDb()->findAll();
        $this->getDb()->reset();

        if (count($results) === 0) {
            return [];
        }

        $list = [];
        foreach ($results as $result) {
            $model = $this->getNewModel();
            $model->set($this->_parseDbResponse($result));
            $model->afterFind();
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Parses DB response
     *
     * @param array $response DB Response
     *
     * @return array
     */
    private function _parseDbResponse($response)
    {
        if (is_array($response) === false) {
            return [];
        }

        $helpList = [];
        $list = [];

        foreach ($response as $fullFieldName => $value) {
            if (strpos($fullFieldName, Db::SEPARATOR) === false) {
                $list[$fullFieldName] = $value;
                continue;
            }

            list($alias, $field)
                = explode(Db::SEPARATOR, $fullFieldName, 2);
            if (array_key_exists($alias, $helpList) === false) {
                $helpList[$alias] = [];
            }

            $helpList[$alias][$field] = $value;
        }

        foreach ($helpList as $key => $response) {
            if ($key === Db::DEFAULT_ALIAS) {
                foreach ($response as $k => $value) {
                    $list[$k] = $value;
                }

                continue;
            }

            $list[$key] = $this->_parseDbResponse($response);
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
    public final function setDbBeforeFind($alias = Db::DEFAULT_ALIAS)
    {
        $info = $this->getFieldsInfo();
        $dbObject = $this->getDb();

        $dbObject->addSelect(self::PK_FIELD, $alias);

        foreach (array_keys($info) as $field) {
            $dbObject->addSelect($field, $alias);

            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$field]
            );
            if ($this->_withRelations === true
                && $hasRelation === true
            ) {
                $relationModel = $this->getRelationModelByFieldName($field);
                if ($relationModel instanceof AbstractModel === false) {
                    continue;
                }

                $relationField = $this->getRelationName($field);

                $relationAlias = $alias . Db::SEPARATOR . $relationField;
                if ($alias === Db::DEFAULT_ALIAS) {
                    $relationAlias = $relationField;
                }

                $hasExceptRelation = in_array(
                    $relationAlias,
                    $this->_exceptRelations
                );
                if ($hasExceptRelation === true) {
                    continue;
                }

                $relationModel
                    ->withRelations()
                    ->exceptRelations($this->_exceptRelations);
                $relationModel->setDb($this->getDb());

                $dbObject->addJoin(
                    $relationModel->getTableName(),
                    $relationAlias,
                    $alias,
                    $field
                );

                $relationModel->setDbBeforeFind($relationAlias);
            }
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
        $results = $this->setDbBeforeFind()->getDb()->findAll();
        $this->getDb()->reset();

        return count($results);
    }

    /**
     * Executes after finding
     *
     * @return void
     */
    protected function afterFind()
    {
    }
}
