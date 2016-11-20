<?php

namespace EE\Applications\TemplateEmailsBundle\Service;

/**
 * Class EmailService
 *
 * @package EE\Applications\TemplateEmailsBundle\Service
 */
class EmailService extends AbstractService
{

    /**
     * Holder for the email subject
     *
     * @var string
     */
    protected $subject;

    /**
     * Holder for the email sender name
     *
     * @var string
     */
    protected $fromName;

    /**
     * Holder for the email address
     *
     * @var string
     */
    protected $fromEmail;

    /**
     * Email address
     *
     * @var string
     */
    protected $email;

    /**
     * Setter for the email subject
     *
     * @param string $email
     *
     * @return EmailService
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Getter for the Email Subject
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Setter for the email subject
     *
     * @param string $subject
     *
     * @return EmailService
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Getter for the Email Subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Setter for the email sender name
     *
     * @param string $fromName
     *
     * @return EmailService
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
        return $this;
    }

    /**
     * Getter for the email sender name
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Getter for the sender email address
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Setter for the senders email address (NOT RECIPIENT)
     *
     * @param string $fromEmail
     *
     * @return EmailService
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    /**
     * Sends Email
     *
     * @param string $body
     *
     * @return int
     */
    public function sendEmail($body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->getSubject())
            ->setFrom($this->getFromEmail(), $this->getFromName())
            ->setTo($this->getEmail())
            ->setBody($body, 'text/html');

        $mailService = $this->container->get('mailer');
        $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
        $mailService->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));

        $result = $mailService->send($message);

        $debugText = "
            Sender email: {emailSender}.
            Sender name: {senderName}.
            Email: {email}.
            Subject: {subject}.
            Body: {body}.
        ";
        $debugData = [
            "emailSender" => $this->getFromEmail(),
            "senderName"  => $this->getFromName(),
            "email"       => $this->getEmail(),
            "subject"     => $this->getSubject(),
            "body"        => $body
        ];
        if ($result > 0) {
            $this->getLogger()->debug("Email has been successfully sent. " . $debugText, $debugData);
        } else {
            $this->getLogger()->error("Unable to save email. " . $debugText, $debugData);

            throw new \RuntimeException("An error occurred while sending email");
        }

        return $result;
    }
}
