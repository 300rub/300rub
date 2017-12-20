<?php

namespace testS\models\_abstract;

use testS\application\components\Db;
use testS\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractFindModel extends AbstractBaseModel
{

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
     * @return AbstractModel
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
     * @return AbstractModel
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
     * @return AbstractModel
     */
    public function withRelations()
    {
        $this->_withRelations = true;
        return $this;
    }

    /**
     * Without all relations
     *
     * @return AbstractModel
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
     * @return AbstractModel
     */
    public function exceptRelations(array $aliases)
    {
        $this->_exceptRelations = $aliases;
        return $this;
    }

    /**
     * Adds condition to select latest model
     *
     * @return AbstractModel
     */
    public function latest()
    {
        $this->getDb()->setOrder(sprintf('%s.id DESC', Db::DEFAULT_ALIAS));
        return $this;
    }

    /**
     * Adds ORDER BY to SQL request
     *
     * @param string|array $value
     * @param string       $alias
     * @param bool         $isDesc
     *
     * @return AbstractModel
     */
    public function ordered($value = 'name', $alias = Db::DEFAULT_ALIAS, $isDesc = false)
    {
        if ($isDesc === true) {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }

        if (is_array($value)) {
            $list = [];
            foreach ($value as $v) {
                $list[] = sprintf('%s.%s', $alias, $v);
            }

            $orderBy = implode(',', $list);
        } else {
            $orderBy = sprintf('%s.%s', $alias, $value);
        }

        $this->getDb()->setOrder(sprintf('%s %s', $orderBy, $order));

        return $this;
    }

    /**
     * Adds in condition to SQL request
     *
     * @param string $field
     * @param array  $values
     * @param string $alias
     *
     * @return AbstractModel
     */
    public function in($field, $values, $alias = Db::DEFAULT_ALIAS)
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
     * @param string $fieldName
     * @param bool   $isFind
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    protected function getRelationModelByFieldName($fieldName, $isFind = false)
    {
        $info = $this->getFieldsInfo();
        if (!array_key_exists($fieldName, $info)
            || !array_key_exists(self::FIELD_RELATION, $info[$fieldName])
        ) {
            return null;
        }

        $relationField = $this->getRelationName($fieldName);
        $relationModelName = $info[$fieldName][self::FIELD_RELATION];
        if ($this->get($relationField) instanceof $relationModelName) {
            return $this->get($relationField);
        }

        $model = $this->_getModelByName($relationModelName);

        if ($isFind === false) {
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
     * @param $name
     *
     * @return AbstractModel
     */
    private function _getModelByName($name)
    {
        return new $name;
    }

    /**
     * Gets one or more fields
     *
     * @param string|string[] $param
     * @param string|string[] $except
     *
     * @return mixed
     *
     * @throws ModelException
     */
    public final function get($param = null, $except = null)
    {
        $fields = $this->getFields();

        if ($param === null) {
            if (is_array($except)) {
                $list = [];
                foreach ($fields as $key => $value) {
                    if (!in_array($key, $except)) {
                        $list[$key] = $value;
                    }
                }

                return $list;
            }

            return $fields;
        }

        if (is_array($param)) {
            $list = [];
            foreach ($param as $field) {
                if (!array_key_exists($field, $fields)) {
                    throw new ModelException(
                        'Unable to find the field {field} from the model {model}',
                        [
                            'field' => $field,
                            'model' => get_class($this)
                        ]
                    );
                }

                $list[$field] = $this->getField($field);
            }

            return $list;
        }

        if (!array_key_exists($param, $fields)) {
            throw new ModelException(
                'Unable to find field {field} for model {model}',
                [
                    'field' => $param,
                    'model' => get_class($this)
                ]
            );
        }

        return $this->getField($param);
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

        if (!$result) {
            return null;
        }

        $model = new $this;
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

        if (!$results) {
            return [];
        }

        $list = [];
        foreach ($results as $result) {
            $model = new $this;
            $model->set($this->_parseDbResponse($result));
            $model->afterFind();
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Parses DB response
     *
     * @param array $response
     *
     * @return array
     */
    private function _parseDbResponse(array $response)
    {
        $helpList = [];
        $list = [];

        foreach ($response as $fullFieldName => $value) {
            if (strripos($fullFieldName, Db::SEPARATOR)) {
                list($alias, $field) = explode(Db::SEPARATOR, $fullFieldName, 2);
                if (!array_key_exists($alias, $helpList)) {
                    $helpList[$alias] = [];
                }

                $helpList[$alias][$field] = $value;
            } else {
                $list[$fullFieldName] = $value;
            }
        }

        foreach ($helpList as $key => $response) {
            if ($key === Db::DEFAULT_ALIAS) {
                foreach ($response as $k => $value) {
                    $list[$k] = $value;
                }
            } else {
                $list[$key] = $this->_parseDbResponse($response);
            }
        }

        return $list;
    }

    /**
     * Sets DB before find
     *
     * @param string $alias
     *
     * @return AbstractModel
     */
    public final function setDbBeforeFind($alias = Db::DEFAULT_ALIAS)
    {
        $info = $this->getFieldsInfo();
        $db = $this->getDb();

        $db->addSelect(self::PK_FIELD, $alias);

        foreach ($info as $field => $value) {
            $db->addSelect($field, $alias);

            if ($this->_withRelations === true
                && array_key_exists(self::FIELD_RELATION, $info[$field])
            ) {
                $relationModel = $this->getRelationModelByFieldName($field);
                if (!$relationModel instanceof AbstractModel) {
                    continue;
                }

                $relationField = $this->getRelationName($field);

                if ($alias === Db::DEFAULT_ALIAS) {
                    $relationAlias = $relationField;
                } else {
                    $relationAlias = $alias . Db::SEPARATOR . $relationField;
                }

                if (in_array($relationAlias, $this->_exceptRelations)) {
                    continue;
                }

                $relationModel->withRelations()->exceptRelations($this->_exceptRelations);
                $relationModel->setDb($this->getDb());

                $db->addJoin($relationModel->getTableName(), $relationAlias, $alias, $field);

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
     */
    protected function afterFind()
    {
    }
}
