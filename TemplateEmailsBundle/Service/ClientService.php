<?php

namespace EE\Applications\TemplateEmailsBundle\Service;

use EE\Applications\TemplateEmailsBundle\Entity\Placeholder;
use EE\Applications\TemplateEmailsBundle\Entity\PlaceholderValue;
use EE\Applications\TemplateEmailsBundle\Entity\PlaceholderValueGroup;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                sprintf("/%s/", $placeholder->getValidation()->getRegEx()),
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

    /**
     * Gets populated HTML
     *
     * @param int $versionId
     *
     * @return string
     */
    public function getPopulatedVersionBody($versionId)
    {
        $version = $this->getVersionById($versionId);
        $placeholderValues = $this->getPlaceholderValues($versionId);

        $placeholderValuesList = [];
        foreach ($placeholderValues as $placeholderValue) {
            $placeholderValuesList[$placeholderValue->getId()] = $placeholderValue->getValue();
        }

        $placeholders = $this->getPlaceholderWithValues(
            $placeholderValuesList,
            $version->getId()
        );

        $search = [];
        $replace = [];
        foreach ($placeholders as $placeholder) {
            if ($placeholder->getError()) {
                throw new \RuntimeException($placeholder->getError());
            }

            $search[] = sprintf("{{ %s }}", $placeholder->getKey());
            $replace[] = $placeholder->getValue();
        }

        $body = str_replace($search, $replace, $version->getBody());
        $result = preg_match(
            "/(\[\[\s)([a-zA-Z0-9_-]+)(\s\]\])/",
            $body,
            $matches
        );
        if ($result) {
            $this->getLogger()->error(
                "Unable to populate the template's version with ID = {id}, " .
                "placeholders = {placeholders}, matches = {matches}",
                [
                    'id' => $version->getId(),
                    'placeholders' => $placeholderValues,
                    'matches' => $matches
                ]
            );

            throw new \RuntimeException("Unable to populate the template");
        }

        return $body;
    }

    /**
     * Saves placeholder values
     *
     * @param Placeholder[] $placeholders
     * @param int           $versionId
     */
    public function savePlaceholderValues(array $placeholders, $versionId)
    {
        $version = $this->getVersionById($versionId);

        $placeholderValueGroup = new PlaceholderValueGroup();
        $placeholderValueGroup->setVersion($version);
        $this->getEntityManager()->persist($placeholderValueGroup);
        $this->getEntityManager()->flush();

        foreach ($placeholders as $placeholder) {
            $placeholderValue = new PlaceholderValue();
            $placeholderValue->setPlaceholderValueGroup($placeholderValueGroup);
            $placeholderValue->setPlaceholder($placeholder);
            $placeholderValue->setValue($placeholder->getValue());
            $this->getEntityManager()->persist($placeholderValueGroup);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * Gets placeholder values
     *
     * @param $versionId
     *
     * @return \EE\Applications\TemplateEmailsBundle\Entity\PlaceholderValue[]
     */
    public function getPlaceholderValues($versionId)
    {
        return $this
            ->getPlaceholderValueRepository()
            ->createQueryBuilder('pv')
            ->leftJoin('v.placeholderValueGroup', 'pvg')
            ->leftJoin('v.placeholder', 'p')
            ->where('pvg.versionId = :versionId')
            ->setParameter('versionId', $versionId)
            ->getQuery()
            ->getResult();
    }

    public function sendEmail($email, $id)
    {
        $errorMessage = null;
        $successMessage = null;

        try {
            $version = $this->getVersionById($id);
            $body = $this->getPopulatedVersionBody($id);
            if (!$body) {
                throw new \RuntimeException("Unable to send email. The body of the message is empty.");
            }

            $emailService = $this->getEmailService();

            $validator = $this->container->get('validator');
            $emailErrors = $validator->validateValue($email, [new Email(), new NotBlank()]);
            if (count($emailErrors) > 0) {
                $this->getLogger()->error(
                    "Unable to send email. The email address is incorrect. Email: {email}. Version: {id}",
                    [
                        "email" => $email,
                        "id"    => $id
                    ]
                );

                throw new \RuntimeException("Unable to send email. The email address is incorrect.");
            }
            $emailService->setEmail($email);

            if (!$version->getSubject()) {
                throw new \RuntimeException("Unable to send email. The subject of the message is empty.");
            }
            $emailService->setSubject($version->getSubject());

            if ($version->getFromName()) {
                $emailService->setFromName($version->getFromName());
            }

            if ($version->getFromEmail()) {
                $emailService->setFromEmail($version->getFromEmail());
            }

            $result = $emailService->sendEmail($body);
            if ($result > 0) {
                $successMessage = "Your email has been sent successfully!";
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }

        return [
            'email'          => $email,
            'errorMessage'   => $errorMessage,
            'successMessage' => $successMessage
        ];
    }
}
