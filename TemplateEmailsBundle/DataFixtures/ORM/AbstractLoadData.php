<?php

namespace EE\Applications\TemplateEmails\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface AS FI;
use Symfony\Component\DependencyInjection\ContainerAwareInterface AS CA;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface AS OF;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractLoadData
 *
 * @package EE\Applications\TemplateEmails\DataFixtures\ORM
 */
abstract class AbstractLoadData extends AbstractFixture implements FI, CA, OF
{

    /**
     * The orders in which fixtures will be loaded
     */
    const ORDER_TEMPLATE = 1;
    const ORDER_VALIDATION = 2;
    const ORDER_VERSION = 3;
    const ORDER_PLACEHOLDER = 4;

    /**
     * Names (Entity and Fixture)
     */
    const NAME_TEMPLATE = "Template";
    const NAME_VALIDATION = "Validation";
    const NAME_VERSION = "Version";
    const NAME_PLACEHOLDER = "Placeholder";

    /**
     * Container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Gets entity's name
     *
     * @return string
     */
    abstract protected function getName();

    /**
     * Sets entity. Used in child classes
     *
     * @param object $entity
     *
     * @return object
     */
    protected function setEntity($entity)
    {
        return $entity;
    }

    /**
     * Load
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fixture = $this->getFixture();
        foreach ($fixture as $id => $data) {
            $entity = $this->getEntity(json_encode($data));
            $entity = $this->setEntity($entity);
            $manager->persist($entity);
            $manager->flush();
            $this->setReference($this->getName() . "-{$id}", $entity);
        }
    }

    /**
     * Sets container
     *
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Gets Serializer
     *
     * @return \JMS\Serializer\Serializer
     */
    protected function getSerializer()
    {
        return $this->container->get('serializer');
    }

    /**
     * Gets entity
     *
     * @param string $json
     *
     * @return object
     */
    protected function getEntity($json)
    {
        return $this->getSerializer()->deserialize(
            $json,
            "EE\\Applications\\TemplateEmailsBundle\\Entity\\" . $this->getName(),
            "json"
        );
    }

    /**
     * Gets fixture's data
     *
     * @return array
     */
    protected function getFixture()
    {
        return json_decode(
            file_get_contents(
                __DIR__ . "/../../Resources/data-fixtures/" . $this->getName() . ".json"
            ),
            true
        );
    }
}
