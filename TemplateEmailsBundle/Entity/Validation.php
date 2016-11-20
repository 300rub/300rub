<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Validation entity
 *
 * @ORM\Table(
 *     name="validations"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="Validation"
 * )
 */
class Validation
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
     * Key
     *
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     *
     * @SWG\Property(
     *   name="key",
     *   type="string",
     *   description="Key"
     * )
     *
     * @Assert\NotBlank(message = "The 'Key' field should not be empty")
     * @Assert\Length(max=25, maxMessage="Maximum length of the 'Key' is 25 characters")
     */
    private $key;

    /**
     * Name
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="name",
     *   type="string",
     *   description="Name"
     * )
     *
     * @Assert\NotBlank(message = "The 'Name' field should not be empty")
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'Name' is 50 characters")
     */
    private $name;

    /**
     * Regular expression
     *
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @SWG\Property(
     *   name="regEx",
     *   type="string",
     *   description="Regular expression"
     * )
     *
     * @Assert\NotBlank(message = "The 'Regular expression' field should not be empty")
     *
     * @SerializedName("regEx")
     */
    private $regEx;

    /**
     * Sets id
     *
     * @param int $id
     *
     * @return Validation
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
     * Sets Key
     *
     * @param string $key
     *
     * @return Validation
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
     * Sets Name
     *
     * @param string $name
     *
     * @return Validation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Regular Expression
     *
     * @param string $regEx
     *
     * @return Validation
     */
    public function setRegEx($regEx)
    {
        $this->regEx = $regEx;
        return $this;
    }

    /**
     * Gets Regular Expression
     *
     * @return string
     */
    public function getRegEx()
    {
        return $this->regEx;
    }
}
