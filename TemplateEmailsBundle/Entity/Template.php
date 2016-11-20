<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Template entity
 *
 * @ORM\Table(
 *     name="templates"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="Template"
 * )
 */
class Template
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
     * Is active
     *
     * @ORM\Column(type="boolean")
     *
     * @SWG\Property(
     *   name="isActive",
     *   type="boolean",
     *   description="Is the template active"
     * )
     *
     * @SerializedName("isActive")
     */
    private $isActive;

    /**
     * Sets id
     *
     * @param int $id
     *
     * @return Template
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
     * Sets isActive
     *
     * @param boolean $isActive
     *
     * @return Template
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Gets isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
