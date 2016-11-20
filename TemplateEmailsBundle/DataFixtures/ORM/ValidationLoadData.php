<?php

namespace EE\Applications\TemplateEmails\DataFixtures\ORM;

require_once("AbstractLoadData.php");

/**
 * Class ValidationLoadData
 *
 * @package EE\Applications\TemplateEmails\DataFixtures\ORM
 */
class ValidationLoadData extends AbstractLoadData
{

    /**
     * Gets Entity's name
     *
     * @return string
     */
    protected function getName()
    {
        return self::NAME_VALIDATION;
    }

    /**
     * Gets the order in which fixtures will be loaded
     *
     * @return integer
     */
    public function getOrder()
    {
        return self::ORDER_VALIDATION;
    }
}
