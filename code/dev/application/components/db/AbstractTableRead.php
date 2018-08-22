<?php

namespace ss\application\components\db;

/**
 * Abstract class to work with table reading
 */
abstract class AbstractTableRead extends AbstractTable
{

    /**
     * Select
     *
     * @var array
     */
    private $_select = [];

    /**
     * Order
     *
     * @var string
     */
    private $_order = '';

    /**
     * Limit
     *
     * @var string
     */
    private $_limit = '';

    /**
     * Sets select
     *
     * @param string $field   Field
     * @param string $alias   Table alias
     * @param string $asValue As value
     *
     * @return AbstractTableRead
     */
    public function addSelect(
        $field,
        $alias = self::DEFAULT_ALIAS,
        $asValue = null
    ) {
        if ($asValue === null) {
            $asValue = sprintf(
                '%s_%s',
                $alias,
                $field
            );
        }

        $selectItem = sprintf(
            '%s.%s AS %s',
            $alias,
            $field,
            $asValue
        );

        if (in_array($selectItem, $this->_select) === false) {
            $this->_select[] = $selectItem;
        }

        return $this;
    }

    /**
     * Gets select
     *
     * @return array
     */
    protected function getSelect()
    {
        return $this->_select;
    }

    /**
     * Sets order
     *
     * @param string $order Order by
     *
     * @return AbstractTableRead
     */
    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }

    /**
     * Gets order
     *
     * @return string
     */
    protected function getOrder()
    {
        return $this->_order;
    }

    /**
     * Sets limit
     *
     * @param string $limit Limit value
     *
     * @return AbstractTableRead
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    /**
     * Gets limit
     *
     * @return string
     */
    protected function getLimit()
    {
        return $this->_limit;
    }

    /**
     * Finds ine record
     *
     * @return array
     */
    public function find()
    {
        return $this->fetch(
            $this->_getQuery(),
            $this->getParameters()
        );
    }

    /**
     * Finds many records
     *
     * @return array
     */
    public function findAll()
    {
        return $this->fetchAll(
            $this->_getQuery(),
            $this->getParameters()
        );
    }

    /**
     * Gets query
     *
     * @return string
     */
    private function _getQuery()
    {
        $query = sprintf(
            'SELECT' . ' %s FROM %s AS %s',
            implode(',', $this->getSelect()),
            $this->getTable(),
            self::DEFAULT_ALIAS
        );

        if (count($this->getJoin()) > 0) {
            $query .= sprintf(' %s', implode(' ', $this->getJoin()));
        }

        if ($this->getWhere() !== '') {
            $query .= sprintf(' WHERE %s', $this->getWhere());
        }

        if ($this->getOrder() !== '') {
            $query .= sprintf(' ORDER BY %s', $this->getOrder());
        }

        if ($this->getLimit() !== '') {
            $query .= sprintf(' LIMIT %s', $this->getLimit());
        }

        return $query;
    }
}
