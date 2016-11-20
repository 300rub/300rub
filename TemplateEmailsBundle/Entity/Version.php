<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Version entity
 *
 * @ORM\Table(
 *     name="versions"
 * )
 * @ORM\Entity
 *
 * @SWG\Model(
 *   id="Version"
 * )
 */
class Version
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
     * Template ID
     *
     * @var integer
     *
     * @ORM\Column(name="templateId", type="integer")
     *
     * @SWG\Property(
     *   name="templateId",
     *   type="integer",
     *   description="Template ID"
     * )
     *
     * @SerializedName("categoryId")
     */
    private $templateId;

    /**
     * Owning template
     *
     * @var Template
     *
     * @ORM\ManyToOne(
     *   targetEntity="\EE\Applications\TemplateEmailsBundle\Entity\Template"
     * )
     * @ORM\JoinColumn(
     *   name="templateId",
     *   referencedColumnName="id"
     * )
     */
    private $template;

    /**
     * Created Date
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @SWG\Property(
     *   name="createdDate",
     *   type="string",
     *   description="Created Date"
     * )
     *
     * @SerializedName("createdDate")
     */
    private $createdDate;

    /**
     * Created User
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="createdUser",
     *   type="string",
     *   description="Created User"
     * )
     *
     * @Assert\NotBlank(message = "The 'User' field should not be empty")
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'User' is 50 characters")
     *
     * @SerializedName("createdUser")
     */
    private $createdUser;

    /**
     * Message body
     *
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @SWG\Property(
     *   name="body",
     *   type="string",
     *   description="Message body"
     * )
     *
     * @Assert\NotBlank(message = "The 'Message Content' field should not be empty")
     */
    private $body;

    /**
     * Message subject
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @SWG\Property(
     *   name="subject",
     *   type="string",
     *   description="Message subject"
     * )
     *
     * @Assert\NotBlank(message = "The 'Message subject' field should not be empty")
     * @Assert\Length(max=100, maxMessage="Maximum length of the 'Message subject' is 100 characters")
     */
    private $subject;

    /**
     * Template name
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @SWG\Property(
     *   name="name",
     *   type="string",
     *   description="Template name"
     * )
     *
     * @Assert\NotBlank(message = "The 'Template name' field should not be empty")
     * @Assert\Length(max=100, maxMessage="Maximum length of the 'Template name' is 100 characters")
     */
    private $name;

    /**
     * Template description
     *
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @SWG\Property(
     *   name="description",
     *   type="string",
     *   description="Template description"
     * )
     */
    private $description;

    /**
     * From name
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @SWG\Property(
     *   name="createdUser",
     *   type="string",
     *   description="From name"
     * )
     *
     * @Assert\NotBlank(message = "The 'From name' field should not be empty")
     * @Assert\Length(max=50, maxMessage="Maximum length of the 'From name' is 50 characters")
     *
     * @SerializedName("fromName")
     */
    private $fromName;


    /**
     * From email
     *
     * @var string
     *
     * @ORM\Column(type="string", length=75)
     *
     * @SWG\Property(
     *   name="createdUser",
     *   type="string",
     *   description="From email"
     * )
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     *
     * @SerializedName("fromEmail")
     */
    private $fromEmail;

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
}
