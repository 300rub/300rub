<?php

namespace EE\Applications\TemplateEmails\DataFixtures\ORM;

require_once("AbstractLoadData.php");

/**
 * Class CategoryLoadData
 *
 * @package EE\Applications\TemplateEmails\DataFixtures\ORM
 */
class TemplateLoadData extends AbstractLoadData
{

    /**
     * Gets Entity's name
     *
     * @return string
     */
    protected function getName()
    {
        return self::NAME_TEMPLATE;
    }

    /**
     * Gets the order in which fixtures will be loaded
     *
     * @return integer
     */
    public function getOrder()
    {
        return self::ORDER_TEMPLATE;
    }
}
