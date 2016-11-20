<?php

namespace EE\Applications\TemplateEmails\DataFixtures\ORM;

require_once("AbstractLoadData.php");

/**
 * Class VersionLoadData
 *
 * @package EE\Applications\TemplateEmails\DataFixtures\ORM
 */
class VersionLoadData extends AbstractLoadData
{

    /**
     * Gets Entity's name
     *
     * @return string
     */
    protected function getName()
    {
        return self::NAME_VERSION;
    }

    /**
     * Gets the order in which fixtures will be loaded
     *
     * @return integer
     */
    public function getOrder()
    {
        return self::ORDER_VERSION;
    }

    /**
     * Sets entity
     *
     * @param \EE\Applications\TemplateEmailsBundle\Entity\Version $entity
     *
     * @return mixed
     */
    protected function setEntity($entity)
    {
        $entity->setTemplate(
            $this->getReference(self::NAME_TEMPLATE . "-" . $entity->getTemplateId())
        );

        return $entity;
    }
}
