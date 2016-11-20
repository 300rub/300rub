<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlaceholderValueGroup entity
 *
 * @ORM\Table(
 *     name="placeholderValueGroups"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="PlaceholderValueGroup"
 * )
 */
class PlaceholderValueGroup
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
     * Sets id
     *
     * @param int $id
     *
     * @return PlaceholderValueGroup
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
     * @return PlaceholderValueGroup
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
     * @return PlaceholderValueGroup
     */
    public function setVersion(Version $version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Gets Template
     *
     * @return Version
     */
    public function getVersion()
    {
        return $this->version;
    }
}
