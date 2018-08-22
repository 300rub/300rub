<?php

namespace ss\application\components\db;

use ss\application\App;

/**
 * Abstract class to work with table writing
 */
abstract class AbstractTableWrite extends AbstractTableRead
{

    /**
     * Fields
     *
     * @var string[]
     */
    private $_fields = [];

    /**
     * Adds field
     *
     * @param string $field Field name
     *
     * @return AbstractTableWrite
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
     * Inserts a record to DB
     * If success - returns new ID
     *
     * @throws AbstractTableWrite
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
            $this->getTableName(),
            implode(',', $this->getFields()),
            implode(',', $values)
        );

        $this->execute($query, $this->getParameters());

        return App::getInstance()
            ->getDb()
            ->getActivePdo()
            ->lastInsertId();
    }

    /**
     * Updates a record
     *
     * @return AbstractTableWrite
     */
    public function update()
    {
        $sets = [];
        foreach ($this->getFields() as $field) {
            $sets[] = sprintf('%s = :%s', $field, $field);
        }

        $query = sprintf(
            'UPDATE' . ' %s SET %s WHERE %s',
            $this->getTableName(),
            implode(',', $sets),
            $this->getWhere()
        );

        $this->execute($query, $this->getParameters());

        return $this;
    }

    /**
     * Deletes a record
     *
     * @return AbstractTableWrite
     */
    public function delete()
    {
        $query = sprintf(
            'DELETE' . ' FROM %s WHERE %s',
            $this->getTableName(),
            $this->getWhere()
        );

        $this->execute($query, $this->getParameters());

        return $this;
    }
}
