<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Placeholder entity
 *
 * @ORM\Table(
 *     name="Placeholders"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="Placeholder"
 * )
 */
class Placeholder
{

    /**
     * Database ID, PK
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @SWG\Property(
     *   name="id",
     *   type="integer",
     *   description="Unique identifier"
     * )
     */
    private $id;

    /**
     * Version ID
     *
     * @var integer
     *
     * @ORM\Column(name="versionId", type="integer")
     *
     * @SWG\Property(
     *   name="versionId",
     *   type="integer",
     *   description="Version ID"
     * )
     *
     * @SerializedName("versionId")
     */
    private $versionId;

    /**
     * Version
     *
     * @var Version
     *
     * @ORM\ManyToOne(
     *   targetEntity="\EE\Applications\TemplateEmailsBundle\Entity\Version"
     * )
     * @ORM\JoinColumn(
     *   name="versionId",
     *   referencedColumnName="id"
     * )
     */
    private $version;

    /**
     * Validation ID
     *
     * @var integer
     *
     * @ORM\Column(name="validationId", type="integer")
     *
     * @SWG\Property(
     *   name="validationId",
     *   type="integer",
     *   description="Validation ID"
     * )
     *
     * @SerializedName("validationId")
     */
    private $validationId;

    /**
     * Validation
     *
     * @var Validation
     *
     * @ORM\ManyToOne(
     *   targetEntity="\EE\Applications\TemplateEmailsBundle\Entity\Validation"
     * )
     * @ORM\JoinColumn(
     *   name="validationId",
     *   referencedColumnName="id"
     * )
     */
    private $validation;

    /**
     * Key
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="key",
     *   type="string",
     *   description="Key"
     * )
     *
     * @Assert\NotBlank(message = "The 'Key' field should not be empty")
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'Key' is 50 characters")
     */
    private $key;

    /**
     * Label
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="label",
     *   type="string",
     *   description="Label"
     * )
     *
     * @Assert\NotBlank(message = "The 'Label' field should not be empty")
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'Label' is 50 characters")
     */
    private $label;

    /**
     * Form placeholder
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="formPlaceholder",
     *   type="string",
     *   description="Form placeholder"
     * )
     *
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'Form placeholder' is 50 characters")
     *
     * @SerializedName("formPlaceholder")
     */
    private $formPlaceholder;

    /**
     * Sort
     *
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     *
     * @SWG\Property(
     *   name="sort",
     *   type="integer",
     *   description="Sort"
     * )
     */
    private $sort;

    /**
     * Value
     *
     * @var string
     */
    private $value;

    /**
     * Error
     *
     * @var bool
     */
    private $error;

    /**
     * Sets id
     *
     * @param int $id
     *
     * @return Placeholder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Version ID
     *
     * @param int $versionId
     *
     * @return Placeholder
     */
    public function setVersionId($versionId)
    {
        $this->versionId = $versionId;
        return $this;
    }

    /**
     * Gets Version ID
     *
     * @return int
     */
    public function getVersionId()
    {
        return $this->versionId;
    }

    /**
     * Sets Version
     *
     * @param Version $version
     *
     * @return Placeholder
     */
    public function setVersion(Version $version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Gets Version
     *
     * @return Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets Validation ID
     *
     * @param int $validationId
     *
     * @return Placeholder
     */
    public function setValidationId($validationId)
    {
        $this->validationId = $validationId;
        return $this;
    }

    /**
     * Gets Validation ID
     *
     * @return int
     */
    public function getValidationId()
    {
        return $this->validationId;
    }

    /**
     * Sets Validation
     *
     * @param Validation $validation
     *
     * @return Placeholder
     */
    public function setValidation(Validation $validation)
    {
        $this->validation = $validation;
        return $this;
    }

    /**
     * Gets Validation
     *
     * @return Validation
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Sets Key
     *
     * @param string $key
     *
     * @return Placeholder
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Gets Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets Label
     *
     * @param string $label
     *
     * @return Placeholder
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Gets Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets Form Placeholder
     *
     * @param string $formPlaceholder
     *
     * @return Placeholder
     */
    public function setFormPlaceholder($formPlaceholder)
    {
        $this->formPlaceholder = $formPlaceholder;
        return $this;
    }

    /**
     * Gets Form Placeholder
     *
     * @return string
     */
    public function getFormPlaceholder()
    {
        return $this->formPlaceholder;
    }

    /**
     * Sets Sort
     *
     * @param int $sort
     *
     * @return Placeholder
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Gets Sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Sets Value
     *
     * @param string $value
     *
     * @return Placeholder
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Gets Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets error
     *
     * @param bool $error
     *
     * @return Placeholder
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Gets error
     *
     * @return bool
     */
    public function getError()
    {
        return $this->error;
    }
}
