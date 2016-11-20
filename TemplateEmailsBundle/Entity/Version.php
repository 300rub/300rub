<?php

namespace EE\Applications\TemplateEmailsBundle\Entity;

use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

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
     * Template
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
     * Sets id
     *
     * @param int $id
     *
     * @return Version
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
     * Sets Template ID
     *
     * @param int $templateId
     *
     * @return Version
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * Gets Template ID
     *
     * @return int
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Sets Template
     *
     * @param Template $template
     *
     * @return Version
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Gets Template
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets date created
     *
     * @param \DateTime $datetime
     *
     * @return Version
     */
    public function setCreatedDate(\DateTime $datetime)
    {
        $this->createdDate = $datetime;
        return $this;
    }

    /**
     * Gets date created
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Sets Created User
     *
     * @param string $createdUser
     *
     * @return Version
     */
    public function setCreatedUser($createdUser)
    {
        $this->createdUser = $createdUser;
        return $this;
    }

    /**
     * Gets Created User
     *
     * @return string
     */
    public function getCreatedUser()
    {
        return $this->createdUser;
    }

    /**
     * Sets Message body
     *
     * @param string $body
     *
     * @return Version
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Gets Message body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets Message subject
     *
     * @param string $subject
     *
     * @return Version
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Gets Message subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets Template name
     *
     * @param string $name
     *
     * @return Version
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets Template name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Template description
     *
     * @param string $description
     *
     * @return Version
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets Template description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets From Name
     *
     * @param string $fromName
     *
     * @return Version
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
        return $this;
    }

    /**
     * Gets From Name
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Sets From Email
     *
     * @param string $fromEmail
     *
     * @return Version
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    /**
     * Gets From Email
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }
}
