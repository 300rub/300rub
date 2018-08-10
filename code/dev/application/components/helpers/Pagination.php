<?php

namespace ss\application\components\helpers;

use ss\application\App;

/**
 * Class to work with pagination
 */
class Pagination
{

    /**
     * Types
     */
    const TYPE_FIRST = 'first';
    const TYPE_PREV = 'prev';
    const TYPE_NEXT = 'next';
    const TYPE_LAST = 'last';
    const TYPE_NUMBER = 'number';

    /**
     * Size
     */
    const SIZE = 10;

    /**
     * Last page
     *
     * @var integer
     */
    private $_lastPage = 0;

    /**
     * Current page
     *
     * @var integer
     */
    private $_currentPage = 0;

    /**
     * Block ID
     *
     * @var integer
     */
    private $_blockId = 0;

    /**
     * Parameters
     *
     * @var array
     */
    private $_parameters = [];

    /**
     * URI
     *
     * @var string
     */
    private $_uri = '';

    /**
     * From page
     *
     * @var integer
     */
    private $_fromPage = 0;

    /**
     * To page
     *
     * @var integer
     */
    private $_toPage = 0;

    /**
     * Sets last page
     *
     * @param int $lastPage Last page
     *
     * @return Pagination
     */
    public function setLastPage($lastPage)
    {
        $this->_lastPage = (int)$lastPage;
        return $this;
    }

    /**
     * Sets current page
     *
     * @param int $currentPage Current page
     *
     * @return Pagination
     */
    public function setCurrentPage($currentPage)
    {
        $currentPage = (int)$currentPage;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $this->_currentPage = $currentPage;
        return $this;
    }

    /**
     * Sets block ID
     *
     * @param int $blockId Block ID
     *
     * @return Pagination
     */
    public function setBlockId($blockId)
    {
        $this->_blockId = $blockId;
        return $this;
    }

    /**
     * Sets parameters ID
     *
     * @param array $parameters Parameters
     *
     * @return Pagination
     */
    public function setParameters($parameters)
    {
        if (is_array($parameters) === false) {
            $parameters = [];
        }

        if (array_key_exists('page', $parameters) === true) {
            unset($parameters['page']);
        }

        if (array_key_exists('block', $parameters) === true) {
            unset($parameters['block']);
        }

        $this->_parameters = $parameters;
        return $this;
    }

    /**
     * Sets URI
     *
     * @param string $uri URI
     *
     * @return Pagination
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }

    /**
     * Gets HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $tree = $this->_getTree();

        return App::getInstance()->getView()->get(
            'content/components/pagination',
            [
                'tree' => $tree,
            ]
        );
    }

    /**
     * Gets tree
     *
     * @return array
     */
    private function _getTree()
    {
        $tree = [];

        if ($this->_currentPage > 1) {
            $tree[] = [
                'uri'      => $this->_generateUri(1),
                'type'     => self::TYPE_FIRST,
                'isActive' => false,
            ];
            $tree[] = [
                'uri'      => $this->_generateUri($this->_currentPage - 1),
                'type'     => self::TYPE_PREV,
                'isActive' => false,
            ];
        }

        $this->_setFromToPage();
        for ($page = $this->_fromPage; $page <= $this->_toPage; $page++) {
            $isActive = false;
            if ($page === $this->_currentPage) {
                $isActive = true;
            }

            $tree[] = [
                'uri'      => $this->_generateUri($page),
                'type'     => self::TYPE_NUMBER,
                'value'    => $page,
                'isActive' => $isActive,
            ];
        }

        if ($this->_currentPage < $this->_lastPage) {
            $tree[] = [
                'uri'      => $this->_generateUri($this->_currentPage + 1),
                'type'     => self::TYPE_NEXT,
                'isActive' => false,
            ];
            $tree[] = [
                'uri'      => $this->_generateUri($this->_lastPage),
                'type'     => self::TYPE_LAST,
                'isActive' => false,
            ];
        }

        return $tree;
    }

    /**
     * Generates URI
     *
     * @param int $page Page number
     *
     * @return string
     */
    private function _generateUri($page)
    {
        $parameters = $this->_parameters;

        if ($page > 1) {
            $parameters['block'] = $this->_blockId;
            $parameters['page'] = $page;
        }

        if ($page <= 1
            && count($parameters) > 0
        ) {
            $parameters['block'] = $this->_blockId;
        }

        if (count($parameters) === 0) {
            return $this->_uri;
        }

        return sprintf(
            '%s?%s',
            $this->_uri,
            http_build_query($parameters)
        );
    }

    /**
     * Sets from - to page
     *
     * @return Pagination
     */
    private function _setFromToPage()
    {
        $halfSize = (self::SIZE / 2);
        $beforeCount = ($this->_currentPage - 1);
        $afterCount = ($this->_lastPage - $this->_currentPage);

        if (($this->_lastPage - 1) < self::SIZE) {
            $this->_fromPage = 1;
            $this->_toPage = $this->_lastPage;
            return $this;
        }

        if ($beforeCount < $afterCount) {
            if ($beforeCount <= $halfSize) {
                $this->_fromPage = 1;
                $this->_toPage
                    = ($this->_currentPage + (self::SIZE - $beforeCount) - 1);
                return $this;
            }

            $this->_fromPage = ($this->_currentPage - $halfSize);
            $this->_toPage = ($this->_currentPage + $halfSize - 1);
            return $this;
        }

        if ($afterCount <= $halfSize) {
            $this->_toPage = $this->_lastPage;
            $this->_fromPage
                = ($this->_currentPage - (self::SIZE - $afterCount - 1));
            return $this;
        }

        $this->_toPage = ($this->_currentPage + $halfSize - 1);
        $this->_fromPage = ($this->_currentPage - $halfSize);
        return $this;
    }
}
