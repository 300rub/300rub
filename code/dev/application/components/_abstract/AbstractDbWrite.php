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
     * Starts transaction
     *
     * @throws DbException
     *
     * @return AbstractDbWrite
     */
    public function startTransaction()
    {
        foreach ($this->getConnections() as $connection) {
            if ($connection['hasTransaction'] === false) {
                continue;
            }

            /**
             * @var \PDO $pdo
             */
            $pdo = $connection['pdo'];
            if ($pdo->beginTransaction() === false) {
                throw new DbException(
                    sprintf(
                        'Unable to start transaction. Error info: %s',
                        implode(' ,', $pdo->errorInfo())
                    )
                );
            }
        }

        return $this;
    }

    /**
     * Applies transaction
     *
     * @throws DbException
     *
     * @return AbstractDbWrite
     */
    public function commitTransaction()
    {
        foreach ($this->getConnections() as $connection) {
            if ($connection['hasTransaction'] === false) {
                continue;
            }

            /**
             * @var \PDO $pdo
             */
            $pdo = $connection['pdo'];
            if ($pdo->commit() === false) {
                throw new DbException(
                    sprintf(
                        'Unable to commit transaction. Error info: %s',
                        implode(' ,', $pdo->errorInfo())
                    )
                );
            }
        }

        return $this;
    }

    /**
     * Rollbacks transaction
     *
     * @throws DbException
     *
     * @return AbstractDbWrite
     */
    public function rollbackTransaction()
    {
        foreach ($this->getConnections() as $connection) {
            if ($connection['hasTransaction'] === false) {
                continue;
            }

            /**
             * @var \PDO $pdo
             */
            $pdo = $connection['pdo'];
            if ($pdo->rollBack() === false) {
                throw new DbException(
                    sprintf(
                        'Unable to rollback transaction. Error info: %s',
                        implode(' ,', $pdo->errorInfo())
                    )
                );
            }
        }

        return $this;
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
