<?php

namespace testS\tests\selenium;

use Behat\Mink\Session as Base;
use Behat\Mink\Driver\DriverInterface;
use Behat\Mink\Selector\SelectorsHandler;
use Behat\Mink\Element\DocumentElement;

class Session extends Base
{
    protected $page;


    public function __construct(DriverInterface $driver, SelectorsHandler $selectorsHandler = null)
    {
        parent::__construct($driver, $selectorsHandler);
        $this->page = new DocumentElement($this);
    }

    /**
     * Returns page element.
     *
     * @return DocumentElement
     */
    public function getPage()
    {
        return $this->page;
    }
}
