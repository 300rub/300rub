<?php

namespace ss\application\components\_abstract;

use ss\application\exceptions\DbException;

/**
 * Abstract class for working with DB writing
 */
abstract class AbstractDbWrite extends AbstractDbRead
{

    /**
     * Fields
     *
     * @var string[]
     */
    private $_fields = [];

    /**
     * Clears fields
     *
     * @return AbstractDbWrite
     */
    protected function clearFields()
    {
        $this->_fields = [];
        return $this;
    }

    /**
     * Adds field
     *
     * @param string $field Field name
     *
     * @return AbstractDbWrite
     *
     * @throws DbException
     */
    public function addField($field)
    {
        if (in_array($field, $this->_fields) === false) {
            $this->_fields[] = $field;
        }

        return $this;
    }

    /**
     * Gets fields
     *
     * @return string[]
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * Inserts record to DB
     * If success - returns new ID
     *
     * @throws DbException
     *
     * @return int
     */
    public function insert()
    {
        $values = [];
        foreach ($this->getFields() as $field) {
            $values[] = sprintf(':%s', $field);
        }

        $query = sprintf(
            'INSERT' . ' INTO %s (%s) VALUES (%s)',
            $this->getTable(),
            implode(',', $this->getFields()),
            implode(',', $values)
        );

        $this->execute($query, $this->getParameters());

        return $this->getCurrentPdo()->lastInsertId();
    }

    /**
     * Updates record
     *
     * @throws DbException
     *
     * @return AbstractDbWrite
     */
    public function update()
    {
        $sets = [];
        foreach ($this->getFields() as $field) {
            $sets[] = sprintf('%s = :%s', $field, $field);
        }

        $query = sprintf(
            'UPDATE' . ' %s SET %s WHERE %s',
            $this->getTable(),
            implode(',', $sets),
            $this->getWhere()
        );

        $this->execute($query, $this->getParameters());

        return $this;
    }

    /**
     * Deletes record
     *
     * @throws DbException
     *
     * @return AbstractDbWrite
     */
    public function delete()
    {
        $query = sprintf(
            'DELETE' . ' FROM %s WHERE %s',
            $this->getTable(),
            $this->getWhere()
        );

        $this->execute($query, $this->getParameters());

        return $this;
    }
}
