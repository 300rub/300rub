<?php

namespace ss\application\components\db\_abstract;

use ss\application\exceptions\DbException;

/**
 * Abstract class to work with DB transactions
 */
abstract class AbstractDbTransaction extends AbstractDb
{

    /**
     * Transactions list
     *
     * @var string[]
     */
    private $_transactions = [];

    /**
     * Initiates a transaction
     *
     * @param string $key PDO key
     *
     * @return AbstractDbTransaction
     *
     * @throws DbException
     */
    public function beginTransaction($key)
    {
        $transactionKey = array_search($key, $this->_transactions);
        if ($transactionKey !== false) {
            return $this;
        }

        if ($this->getPdo($key)->beginTransaction() === false) {
            throw new DbException(
                'Unable to start transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        $this->_transactions[] = $key;

        return $this;
    }

    /**
     * Commits a transaction
     *
     * @param string $key PDO key
     *
     * @return AbstractDbTransaction
     *
     * @throws DbException
     */
    public function commit($key)
    {
        $transactionKey = array_search($key, $this->_transactions);
        if ($transactionKey === false) {
            return $this;
        }

        if ($this->getPdo($key)->commit() === false) {
            throw new DbException(
                'Unable to commit transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        unset($this->_transactions[$transactionKey]);

        return $this;
    }

    /**
     * Commits all transactions
     *
     * @return AbstractDbTransaction
     */
    public function commitAll()
    {
        foreach ($this->_transactions as $key) {
            $this->commit($key);
        }

        return $this;
    }

    /**
     * Rolls back a transaction
     *
     * @param string $key PDO key
     *
     * @return AbstractDbTransaction
     *
     * @throws DbException
     */
    public function rollBack($key)
    {
        $transactionKey = array_search($key, $this->_transactions);
        if ($transactionKey === false) {
            return $this;
        }

        if ($this->getPdo($key)->rollBack() === false) {
            throw new DbException(
                'Unable to rollback transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        unset($this->_transactions[$transactionKey]);

        return $this;
    }

    /**
     * Rolls back all transactions
     *
     * @return AbstractDbTransaction
     */
    public function rollBackAll()
    {
        foreach ($this->_transactions as $key) {
            $this->rollBack($key);
        }

        return $this;
    }
}
