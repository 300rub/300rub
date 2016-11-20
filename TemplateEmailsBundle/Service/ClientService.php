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

    /**
     * Gets placeholders with values
     *
     * @param array $placeholderValues
     * @param int   $versionId
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\Placeholder[]
     */
    public function getPlaceholderWithValues(array $placeholderValues, $versionId)
    {
        $placeholders = $this->getPlaceholdersByVersionId($versionId);

        foreach ($placeholders as &$placeholder) {
            if (!array_key_exists($placeholder->getId(), $placeholderValues)) {
                $placeholder->setError(
                    sprintf("The '%s' field should not be empty", $placeholder->getLabel())
                );
                continue;
            }

            $value = $placeholderValues[$placeholder->getId()];
            $result = preg_match(
                sprintf("/%s/i", $placeholder->getValidation()->getRegEx()),
                $value
            );
            if (!$result) {
                $placeholder->setError(
                    sprintf("The '%s' field is incorrect", $placeholder->getLabel())
                );
                continue;
            }

            $placeholder->setValue($value);
        }

        return $placeholders;
    }
}
