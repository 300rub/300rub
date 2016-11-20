<?php

namespace EE\Applications\TemplateEmails\DataFixtures\ORM;

require_once("AbstractLoadData.php");

/**
 * Class PlaceholderLoadData
 *
 * @package EE\Applications\TemplateEmails\DataFixtures\ORM
 */
class PlaceholderLoadData extends AbstractLoadData
{

    /**
     * Gets Entity's name
     *
     * @return string
     */
    protected function getName()
    {
        return self::NAME_PLACEHOLDER;
    }

    /**
     * Gets the order in which fixtures will be loaded
     *
     * @return integer
     */
    public function getOrder()
    {
        return self::ORDER_PLACEHOLDER;
    }

    /**
     * Sets entity
     *
     * @param \EE\Applications\TemplateEmailsBundle\Entity\Placeholder $entity
     *
     * @return mixed
     */
    protected function setEntity($entity)
    {
        $entity->setVersion(
            $this->getReference(self::NAME_VERSION . "-" . $entity->getVersionId())
        );

        $entity->setValidation(
            $this->getReference(self::NAME_VALIDATION . "-" . $entity->getValidationId())
        );

        return $entity;
    }
}
