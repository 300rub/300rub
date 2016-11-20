<?php

namespace EE\Applications\TemplateEmailsBundle\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractService
 *
 * @package EE\Applications\TemplateEmailsBundle\Service
 */
abstract class AbstractService extends ContainerAware implements LoggerAwareInterface
{

    /**
     * Logger instance
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Sets Logger
     *
     * @param LoggerInterface $logger
     *
     * @return AbstractService
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Gets Logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets EntityManager
     *
     * @param EntityManager $entityManager
     *
     * @return AbstractService
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * Gets EntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Gets Placeholder Repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getPlaceholderRepository()
    {
        return $this->entityManager->getRepository(
            'EEApplicationsTemplateEmailsBundle:Placeholder'
        );
    }

    /**
     * Gets Template Repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getTemplateRepository()
    {
        return $this->entityManager->getRepository(
            'EEApplicationsTemplateEmailsBundle:Template'
        );
    }

    /**
     * Gets Validation Repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getValidationRepository()
    {
        return $this->entityManager->getRepository(
            'EEApplicationsTemplateEmailsBundle:Validation'
        );
    }

    /**
     * Gets Version Repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getVersionRepository()
    {
        return $this->entityManager->getRepository(
            'EEApplicationsTemplateEmailsBundle:Version'
        );
    }

    /**
     * Gets placeholders by version ID
     *
     * @param int $versionId
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Placeholder[]
     */
    public function getPlaceholdersByVersionId($versionId)
    {
        return $this->getPlaceholderRepository()->findBy(
            ['versionId' => $versionId],
            ['sort' => 'ASC']
        );
    }

    /**
     * Gets all templates
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Template[]
     */
    public function getAllTemplates()
    {
        return $this->getTemplateRepository()->findAll();
    }

    /**
     * Gets active templates
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Template[]
     */
    public function getActiveTemplates()
    {
        return $this->getTemplateRepository()->findBy(['isActive' => true]);
    }

    /**
     * Gets latest version by template ID
     *
     * @param int $templateId
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Version
     */
    public function getLatestVersionByTemplateId($templateId)
    {
        return $this->getVersionRepository()->findOneBy(
            ['templateId' => $templateId],
            ['createdDate' => 'DESC']
        );
    }

    /**
     * Gets all validations
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Validation[]
     */
    public function getAllValidations()
    {
        return $this->getValidationRepository()->findAll();
    }

    /**
     * Find DataStore Expression from a content
     *
     * @param string $content
     *
     * @return array
     */
    protected static function findDataStoreExpressions($content)
    {
        preg_match_all(
            '/\{\{(?!%)\s*((?:[^\s])*)\s*(?<!%)\}\}/i',
            $content,
            $matches
        );

        return array_filter($matches[1]);
    }
}
