<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlaceholderValue entity
 *
 * @ORM\Table(
 *     name="placeholderValues"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="PlaceholderValue"
 * )
 */
class PlaceholderValue
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
     * PlaceholderValueGroup ID
     *
     * @var integer
     *
     * @ORM\Column(name="placeholderValueGroupId", type="integer")
     *
     * @SWG\Property(
     *   name="placeholderValueGroupId",
     *   type="integer",
     *   description="PlaceholderValueGroup ID"
     * )
     *
     * @SerializedName("placeholderValueGroupId")
     */
    private $placeholderValueGroupId;

    /**
     * PlaceholderValueGroup
     *
     * @var PlaceholderValueGroup
     *
     * @ORM\ManyToOne(
     *   targetEntity="\EE\Applications\TemplateEmailsBundle\Entity\PlaceholderValueGroup"
     * )
     * @ORM\JoinColumn(
     *   name="placeholderValueGroupId",
     *   referencedColumnName="id"
     * )
     */
    private $placeholderValueGroup;

    /**
     * Placeholder ID
     *
     * @var integer
     *
     * @ORM\Column(name="placeholderId", type="integer")
     *
     * @SWG\Property(
     *   name="placeholderId",
     *   type="integer",
     *   description="Placeholder ID"
     * )
     *
     * @SerializedName("placeholderId")
     */
    private $placeholderId;

    /**
     * Placeholder
     *
     * @var Placeholder
     *
     * @ORM\ManyToOne(
     *   targetEntity="\EE\Applications\TemplateEmailsBundle\Entity\Placeholder"
     * )
     * @ORM\JoinColumn(
     *   name="placeholderId",
     *   referencedColumnName="id"
     * )
     */
    private $placeholder;

    /**
     * Value
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(
     *   name="value",
     *   type="string",
     *   description="Value"
     * )
     *
     * @Assert\NotBlank(message = "The 'Value' field should not be empty")
     * @Assert\Length(max=255, maxMessage="Maximum length of the 'Value' is 255 characters")
     */
    private $value;

    /**
     * Sets id
     *
     * @param int $id
     *
     * @return PlaceholderValue
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
     * Sets PlaceholderValueGroup ID
     *
     * @param int $placeholderValueGroupId
     *
     * @return PlaceholderValue
     */
    public function setPlaceholderValueGroupId($placeholderValueGroupId)
    {
        $this->placeholderValueGroupId = $placeholderValueGroupId;
        return $this;
    }

    /**
     * Gets PlaceholderValueGroup ID
     *
     * @return int
     */
    public function getPlaceholderValueGroupId()
    {
        return $this->placeholderValueGroupId;
    }

    /**
     * Sets PlaceholderValueGroup
     *
     * @param PlaceholderValueGroup $placeholderValueGroup
     *
     * @return PlaceholderValue
     */
    public function setPlaceholderValueGroup(PlaceholderValueGroup $placeholderValueGroup)
    {
        $this->placeholderValueGroup = $placeholderValueGroup;
        return $this;
    }

    /**
     * Gets PlaceholderValueGroup
     *
     * @return PlaceholderValueGroup
     */
    public function getPlaceholderValueGroup()
    {
        return $this->placeholderValueGroup;
    }

    /**
     * Sets Placeholder ID
     *
     * @param int $placeholderId
     *
     * @return PlaceholderValue
     */
    public function setPlaceholderId($placeholderId)
    {
        $this->placeholderId = $placeholderId;
        return $this;
    }

    /**
     * Gets Placeholder ID
     *
     * @return int
     */
    public function getPlaceholderId()
    {
        return $this->placeholderId;
    }

    /**
     * Sets Placeholder
     *
     * @param Placeholder $placeholder
     *
     * @return PlaceholderValue
     */
    public function setPlaceholder(Placeholder $placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * Gets Placeholder
     *
     * @return Placeholder
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Sets Value
     *
     * @param string $value
     *
     * @return PlaceholderValue
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
}
