<?php

namespace EE\Applications\TemplateEmailsBundle\Service;

/**
 * Class ClientService
 *
 * @package EE\Applications\TemplateEmailsBundle\Service
 */
class ClientService extends AbstractService
{

    /**
     * Gets a list of active versions as $templateId => $name
     *
     * @return array
     */
    public function getActiveVersionKeyValueList()
    {
        $list = [];

        $versions = $this->getLatestVersionList();
        foreach ($versions as $version) {
            $list[$version->getId()] = $version->getName();
        }

        asort($list);

        return $list;
    }

    /**
     * Gets latest version list
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Version[]
     */
    protected function getLatestVersionList()
    {
        return $this
            ->getVersionRepository()
            ->createQueryBuilder('v')
            ->leftJoin('v.template', 't')
            ->where('t.isActive = :isActive')
            ->setParameter('isActive', 1)
            ->groupBy('v.templateId')
            ->orderBy('v.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
